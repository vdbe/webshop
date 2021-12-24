<?php

require_once __DIR__ . '/product.php';

class UserOrder
{
    private int $id;
    private int $user_id;
    public bool $basket;
    public ?DateTime $date;
    public ?DateTime $payedat;

    public function __construct(
        int $id,
        int $user_id,
        bool $basket = false,
        ?DateTime $date = null,
        ?DateTime $payedat = null,
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->basket = $basket;
        $this->date = $date;
        $this->payedat = $payedat;
    }

    public function getID()
    {
        return $this->id;
    }

    /**
     * Place item in UserOrder instance.
     *
     * Creates a new `Order` with as `uo_id` `$this->id`,
     * checks an returns the new stock if return value is below
     * zero it is an error.
     *
     * @param DB $db db instance
     * @param int $product_id product id
     * @param int $amount amount of items to be orderd with id `$product_id`
     * @return int below 0 error 0 or higher new stock
     */
    public function addItem(DB $db, int $product_id, int $amount): int
    {
        // Get Product
        $product = Product::getByID($db, $product_id);

        if ($product_id == null) {
            // Not found
            return -1;
        }

        if ($product->stock < $amount) {
            // Not enough stock
            return -2;
        }

        // Create Order
        $query = <<<SQL
        INSERT INTO `Order`
            (uo_id, product_id, amount)
        VALUES
            (?, ?, ?)
        SQL;
        $db->query($query, 'iii', $this->id, $product_id, $amount);
        $db->close_stmt();
        if ($db->errno) {
            return -3;
        }

        // Update stock
        $product->stock -= $amount;
        $product->update($db);
        return $product->stock;
    }

    public static function new(
        DB $db,
        int $user_id,
        bool $basket = false,
        DateTime $date = null,
        DateTime $payedat = null,
    ): bool {
        $query = <<<SQL
        INSERT INTO UserOrder
            (user_id, uo_basket, uo_date, uo_payedat)
        VALUES
            (?, ?, ?, ?);
        SQL;
        $db->query($query, 'iiss', $user_id, $basket, $date, $payedat);
        $db->close_stmt();

        return !$db->errno;
    }

    public static function basket(DB $db, User $user): UserOrder
    {
        // Check if there is already a basket
        $query = <<<SQL
        SELECT * FROM UserOrder
        WHERE
            uo_basket = 1
            AND user_id = ?
        SQL;
        $db->query($query, 'i', $user->getID());

        if ($row = $db->fetch_row()) {
            // Found an existing basket
            $date = null;
            $payedat = null;

            if ($tmp = $row[3]) {
                $date = new DateTime($tmp);
            }

            if ($tmp = $row[3]) {
                $payedat = new DateTime($tmp);
            }
            return new UserOrder($row[0], $row[1], true, $date, $payedat);
        }

        // Create new basket
        UserOrder::new($db, $user->getID(), true);

        // Plz dont fail on createing the basket;
        return UserOrder::basket($db, $user, true);
    }
}
