<?php

class Category
{
    public static function getCategories(DB $db)
    {
        $query = <<<SQL
            SELECT category_name as name, category_description as description FROM Category
            ORDER BY category_name;
        SQL;

        $db->query($query);

        return $db->fetch_all(MYSQLI_ASSOC);
    }

    public static function getID(DB $db, string $category)
    {
        $query = <<<SQL
            SELECT category_id as id FROM Category
            WHERE category_name = ?;
        SQL;

        echo $category;
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
