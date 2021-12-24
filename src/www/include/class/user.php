<?php

class User
{
    private int $id;
    private string $role_name;
    private datetime $dob;

    public string $displayname;
    public string $firstname;
    public string $lastname;
    public string $email;
    public datetime $lastlogin;

    public function __construct(
        int $id,
        string $role_name,
        datetime $dob,
        string $displayname,
        string $firstname,
        string $lastname,
        string $email,
        datetime $lastlogin,
    ) {
        $this->id = $id;
        $this->role_name = $role_name;
        $this->dob = $dob;
        $this->displayname = $displayname;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->lastlogin = $lastlogin;
    }

    public static function check_if_email_exists(DB $db, string $email): bool
    {
        $ret = false;

        $db->query('SELECT COUNT(1) FROM User WHERE user_email = ?;', 's', $email);
        if ($db->errno) {
            exit($db->error);
        }
        $row = $db->fetch_row();
        $db->close_stmt();
        if ($db->errno) {
            exit($db->error);
        }
        if ($row[0] == 0) {
            // Email doesn't exist
            $ret =  false;
        } else {
            $ret =  true;
        }

        return $ret;
    }

    public static function check_if_displayname_exists(DB $db, string $displayname): bool
    {
        $ret = false;

        $db->query('SELECT COUNT(1) FROM User WHERE user_displayname = ?;', 's', $displayname);
        if ($db->errno) {
            exit($db->error);
        }
        $row = $db->fetch_row();
        $db->close_stmt();
        if ($db->errno) {
            exit($db->error);
        }
        if ($row[0] == 0) {
            // Displayname doesn't exist
            $ret =  false;
        } else {
            $ret =  true;
        }

        return $ret;
    }
    public static function create(
        DB $db,
        int $role_id,
        string $displayname,
        string $firstname,
        string $lastname,
        string $email,
        string $dob,
        string $password,
        int $active,
    ): bool {
        // TODO: Check if displayname already exists
        $query = <<<SQL
        INSERT INTO User
            (ur_id, user_displayname, user_firstname, user_lastname, user_email, user_dateofbirth, user_passwordhash, user_active)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?);
        SQL;

        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $data_of_birth = date('Y-m-d', strtotime($dob));
        $db->query($query, 'issssssi', $role_id, $displayname, $firstname, $lastname, $email, $data_of_birth, $passwordhash, $active);
        $db->close_stmt();
        if ($db->errno) {
            // TODO: Error handling
            exit($db->error);
        }

        return true;
    }

    public static function login(DB $db, string $email, string $password): User|bool
    {
        $query = <<<SQL
        SELECT
            u.user_id, ur.ur_name, u.user_displayname, u.user_firstname, u.user_lastname, u.user_email, u.user_lastlogin, u.user_dateofbirth, u.user_passwordhash
        FROM User AS u
        LEFT JOIN UserRole AS ur
            ON u.ur_id = ur.ur_id
        WHERE
            u.user_active = ? AND u.user_email = ?;
        SQL;

        $db->query($query, 'is', 1, htmlspecialchars($email));
        if ($db->errno) {
            exit($db->error);
        }

        $affected_rows = $db->affected_rows();
        if ($affected_rows > 1) {
            // Multiple matches???
            return false;
        } else if ($affected_rows <= 0) {
            // No match
            return false;
        }

        $row = $db->fetch_row();
        $db->close_stmt();

        if (!password_verify($password, $row[8])) {
            // No password match
            return false;
        }


        $id = $row[0];
        $role_name = $row[1];
        $displayname = $row[2];
        $firstname = $row[3];
        $lastname = $row[4];
        $email = $row[5];
        $lastlogin = new DateTime($row[6]);
        $dob = new DateTime($row[7]);

        $user = new User($id, $role_name, $dob, $displayname, $firstname, $lastname, $email, $lastlogin);
        $user->update_lastlogin($db);

        return $user;
    }

    function update_lastlogin(DB $db): bool
    {
        // This functions only updates last login in the databse
        $query = <<<SQL
               Update User
               SET user_lastlogin = ?
               WHERE user_id = ?;
        SQL;
        $current_datetime = date('Y-m-d H:i:s');

        $db->query($query, 'si', $current_datetime, $this->id);
        $db->close_stmt();
        if ($db->errno) {
            exit($db->error);
        }

        return true;
    }

    function getRole()
    {
        return $this->role_name;
    }

    function getID()
    {
        return $this->id;
    }

    static function getUsers(DB $db)
    {
        $query = <<<SQL
        SELECT
            u.user_id as id, ur.ur_name as rolename, u.user_displayname as displayname, u.user_firstname as firstname,
            u.user_lastname as lastname, u.user_email as email, u.user_lastlogin as lastlogin,
            u.user_dateofbirth as dob, u.user_active as active
        FROM User as u
        LEFT JOIN UserRole AS ur
            ON u.ur_id = ur.ur_id
        SQL;
        $db->query($query);

        $result = $db->fetch_all(MYSQLI_ASSOC);
        $db->close_stmt();

        return $result;
    }

    static function change(DB $db, int $id, string $displayname, string $rolename, bool $active)
    {
        $query = <<<SQL
            UPDATE User
            SET
                user_displayname = ?,
                ur_id = (SELECT ur_id FROM UserRole WHERE ur_name = ?),
                user_active = ?
            WHERE
                user_id = ?;
        SQL;

        $db->query($query, 'ssii', $displayname, $rolename, $active, $id);
        $db->close_stmt();

        return !$db->errno;
    }
}
