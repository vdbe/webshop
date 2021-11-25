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

        $db->query('SELECT 1 FROM User WHERE user_email == ?', 's', $email);
        if ($db->errno) {
            exit($db->error);
        }
        if ($db->affected_rows() == 0) {
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
        bool $active,
    ) {
        $query = '
        INSERT INTO User
            (ur_id, user_displayname, user_firstname, user_lastname, user_email, user_dateofbirth, user_passwordhash, user_active)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)';
        $date_of_birth = 0;
        $db->query($query, 'issssisb', $role_id, $displayname, $firstname, $lastname, $email, $date_of_birth, password_hash($password, PASSWORD_DEFAULT), $active);

        return true;
    }
}
