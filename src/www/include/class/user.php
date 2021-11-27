<?php

class User
{
    private $id;
    private $role_id;
    private $passwordhash;
    private $active;
    private $dob;

    public $displayname;
    public $firstname;
    public $lastname;
    public $email;
    public $lastlogin;

    public static function check_if_exists(DB $db, $email): bool
    {
        $ret = false;

        $db->query('SELECT COUNT(1) FROM User WHERE user_email = ?', 's', $email);
        if ($db->errno) {
            exit($db->error);
        }
        $row = $db->fetch_row();
        if ($db->errno) {
            exit($db->error);
        }
        if ($row[0] == 0) {
            // Email doesn't exist
            $ret =  false;
        } else {
            $ret =  true;
        }

        $db->close_stmt();
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
    ) {
        $query = '
        INSERT INTO User
            (ur_id, user_displayname, user_firstname, user_lastname, user_email, user_dateofbirth, user_passwordhash, user_active)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)';
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $data_of_birth = date('Y-m-d', strtotime($dob));
        $db->query($query, 'issssssi', $role_id, $displayname, $firstname, $lastname, $email, $data_of_birth, $passwordhash, $active);
        if ($db->errno) {
            exit($db->error);
        }

        return true;
    }
}
