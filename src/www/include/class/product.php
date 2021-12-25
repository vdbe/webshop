<?php

require_once __DIR__ . '/category.php';

class Product
{
    private int $id;
    public string $name;
    public string $description;
    public string $category;
    public DateTime $available;
    public int $stock;
    public float $unitprice;


    public function __construct(
        int $id,
        string $name,
        string $description,
        string $category,
        DateTime $available,
        int $stock,
        float $untiprice
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->available = $available;
        $this->stock = $stock;
        $this->unitprice = $untiprice;
    }

    public function update(DB $db)
    {
        $query = <<<SQL
            UPDATE LOW_PRIORITY IGNORE Product
            SET
                product_name = ?,
                product_description = ?,
                category_id = ?,
                product_available = ?,
                product_stock = ?,
                product_unitprice = ?
            WHERE
                product_id = ?
        SQL;

        $date = date_format($this->available, 'Y-m-d');
        $category_id = Category::getID($db, $this->category);
        $db->query($query, 'ssisidi', $this->name, $this->description, $category_id, $date, $this->stock, $this->unitprice, $this->id);
        $db->close_stmt();
        echo $db->error;
    }

    public static function search(DB $db, string $name = "", string $description = "", string $category = '', bool $onlyAvailable = true)
    {
        $query = <<<SQL
        SELECT
            p.product_id as id, p.product_name as name, p.product_description as description, c.category_name as category,
            p.product_available, p.product_stock as stock, p.product_unitprice as unitprice
        FROM Product as p
        LEFT JOIN Category AS c
            ON p.category_id = c.category_id
        WHERE
        SQL;

        if ($onlyAvailable == true) {
            $query .= ' p.product_available <= CURDATE()';
            $query .= ' AND p.product_stock >= 1';
        } else {
            // Dirty fix, I know
            $query .= ' 1=1';
        }

        $name = $name;
        $params = array();
        $types = '';
        $idx = 0;

        if (!empty($name)) {
            $query .= ' AND p.product_name LIKE ?';
            $types .= 's';

            $name = '%' . str_replace(' ', '%', $name) . '%';
            $params[$idx] = &$name;
            $idx++;
        }

        if (!empty($description)) {
            $query .= ' AND p.product_description LIKE ?';
            $types .= 's';

            $description = '%' . str_replace(' ', '%', $description) . '%';
            $params[$idx] = &$description;
            $idx++;
        }

        if (!empty($category)) {
            $query .= ' AND c.category_name = ?';
            $types .= 's';
            $params[$idx] = &$category;
            $idx++;
        }

        $db->query($query, $types, $params);
        $db->execute();

        $products = [];
        while ($row = $db->fetch_row()) {
            array_push($products, new Product($row[0], $row[1], $row[2], $row[3], new DateTime($row[4]), $row[5], $row[6]));
        }
        $db->close_stmt();

        return $products;
    }

    public function getID()
    {
        return $this->id;
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
        $query = <<<SQL
        INSERT INTO Product
            (product_name, product_description, category_id, product_available, product_stock, product_unitprice)
        VALUES
            (?, ?, ?, ?, ?, ?);
        SQL;

        $category_id = Category::getID($db, $category);
        if (empty($category_id)) {
            // TODO: Error handling
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

    public static function getByID(DB $db, int $id, bool $onlyAvailable = true)
    {
        $query = <<<SQL
        SELECT
            p.product_id as id, p.product_name as name, p.product_description as description, c.category_name as category,
            p.product_available, p.product_stock as stock, p.product_unitprice as unitprice
        FROM Product as p
        LEFT JOIN Category AS c
            ON p.category_id = c.category_id
        WHERE
                p.product_id = ?
        SQL;
        if ($onlyAvailable == true) {
            $query .= ' AND p.product_available <= CURDATE()';
        }

        $db->query($query, 'i', $id);

        if ($row = $db->fetch_row()) {
            return new Product($row[0], $row[1], $row[2], $row[3], new DateTime($row[4]), $row[5], $row[6]);
        }

        return null;
    }
}
