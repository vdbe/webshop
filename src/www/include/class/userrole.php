<?php

class UserRole
{
    private int $id;
    public string $name;

    function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function update(DB $db)
    {
        $query = <<<SQL
            UPDATE UserRole
            SET
                ur_name = ?,
            WHERE
                ur_id = ?;
        SQL;

        $db->query($query, 'si', $this->name, $this->id);
        $db->close_stmt();

        return !$db->errno;
    }

    public static function getRoles(DB $db)
    {
        $query = <<<SQL
            SELECT ur_id as id, ur_name as name FROM UserRole
            ORDER BY ur_name;
        SQL;

        $db->query($query);

        return $db->fetch_all(MYSQLI_ASSOC);
    }

    public static function add(DB $db, string $name)
    {
        $query = <<<SQL
            INSERT INTO UserRole (ur_name) VALUES
            (?);
        SQL;
        $db->query($query, 's', $name);
        $db->close_stmt();

        return !$db->errno;
    }

    public static function getID(DB $db, string $name)
    {
        $query = <<<SQL
            SELECT ur_id as id FROM UserRole
            WHERE ur_name = ?;
        SQL;

        $db->query($query, 's', $name);
        $row = $db->fetch_row();
        $db->close_stmt();

        if (empty($row)) {
            return $row;
        } else {
            return $row[0];
        }
    }
}
