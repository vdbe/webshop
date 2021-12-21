<?php

require_once __DIR__ . '/category.php';

class Product
{
    private int $id;
    public string $category;
    public string $name;
    public string $description;
    public DateTime $available;
    public int $stock;
    public float $unitprice;


    public function __construct()
    {
    }

    public static function add(
        DB $db,
        string $name,
        string $description,
        string $category,
        DateTime $available,
        int $stock,
        float $unitprice,
    ) {
        // TODO:
        $query = <<<SQL
        INSERT INTO Product
            (product_name, product_description, category_id, product_available, product_stock, product_unitprice)
        VALUES
            (?, ?, ?, ?, ?, ?);
        SQL;

        $category_id = Category::getID($db, $category);
        if (empty($category_id)) {
            // TODO: Error handling
            echo $category_id;
            return;
        }

        $date = date_format($available, 'Y-m-d');
        $db->query($query, 'ssisid', $name, $description, $category_id, $date, $stock,  $unitprice);
        if ($db->errno) {
            // TODO: Error handling
            exit($db->error);
        } else {
            return true;
        }
    }
}
