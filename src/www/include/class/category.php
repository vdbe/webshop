<?php

class Category
{
    private int $id;
    public string $name;
    public string $description;

    function __construct(int $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function update(DB $db)
    {
        $query = <<<SQL
            UPDATE Category
            SET
                category_name = ?,
                category_description = ?
            WHERE
                category_id = ?;
        SQL;

        $db->query($query, 'ssi', $this->name, $this->description, $this->id);
        $db->close_stmt();

        return !$db->errno;
    }

    public static function getCategories(DB $db)
    {
        $query = <<<SQL
            SELECT category_id as id, category_name as name, category_description as description FROM Category
            ORDER BY category_name;
        SQL;

        $db->query($query);

        return $db->fetch_all(MYSQLI_ASSOC);
    }

    public static function add(DB $db, string $name, string $description)
    {
        $query = <<<SQL
            INSERT INTO Category (category_name, category_description) VALUES
            (?, ?);
        SQL;
        $db->query($query, 'ss', $name, $description);
        $db->close_stmt();

        return !$db->errno;
    }

    public static function getID(DB $db, string $category)
    {
        $query = <<<SQL
            SELECT category_id as id FROM Category
            WHERE category_name = ?;
        SQL;

        $db->query($query, 's', $category);
        $row = $db->fetch_row();
        $db->close_stmt();

        if (empty($row)) {
            return $row;
        } else {
            return $row[0];
        }
    }
}
