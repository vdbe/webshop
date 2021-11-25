<?php

// TODO: proper error handling pbly somthing like `$stmt->errorno` and `$stmt->error`
class DB
{
    protected mysqli $connection;
    protected bool $connection_open = false;
    protected mysqli_stmt $stmt;
    protected bool $stmt_active = false;
    protected bool $ref_binded_stmt = false;

    public int $errno = 0;
    public string $error = '';

    public function __construct(
        string $hostname,
        string $username,
        string $password,
        string $database,
    ) {
        /* Open connection to db */
        $mysqli = new mysqli($hostname, $username, $password, $database);
        if ($mysqli->connect_errno) {
            exit($this->error($mysqli->connect_errno, 'Faile to connect to database: ' . $mysqli->connect_error));
        }

        $this->connection = $mysqli;
    }

    public function __destruct()
    {
        if ($this->connection_open) {
            $this->close();
        }
    }

    private function error($errno, $error): int
    {
        // Keep first error
        if ($this->errno == 0) {
            $this->error = $error;
            $this->errno = $errno;
        }
        return $this->errno;
    }


    // True on success
    public function close(): bool|int
    {
        if ($this->close_stmt() == false) {
            return $this->errno;
        }

        /* Close connectio to db */
        if ($this->connection->close() == false) {
            return $this->error(101, 'Failed to close connection to database.');
        };
        $this->connection_open = false;

        return true;
    }

    // True on success
    public function close_stmt(): bool
    {
        if ($this->stmt_active == false) {
            // Already closed
            return true;
        }

        /* Close statement */
        if ($this->stmt->close() == false) {
            return $this->error(201, 'Failed to close statment.');
        };

        $this->ref_binded_stmt = false;
        $this->stmt_active = false;
        return true;
    }

    public function query(string $query, string $types = ''): db|int
    {
        if ($this->stmt_active) {
            $this->close_stmt();
        }

        $num_args = func_num_args();
        if ($num_args < 1) {
            return $this->error(301, 'You need to provide atleast 1 argument');
        }

        /* Prepare statement */
        $stmt = $this->connection->prepare($query);
        if ($stmt == false) {
            return $this->error(302, 'mysqli::prepare() failed: ' . $this->connection->error);
        }

        if ($num_args > 2) {
            $bind_params = array_slice(func_get_args(), 2);
            if (is_array($bind_params[0])) {
                $args_as_ref = &$bind_params[0];
                $this->ref_binded_stmt = true;
            } else {
                $args_as_ref = array();
                // Find a better way for this
                foreach ($bind_params as $ii => $param) {
                    $args_as_ref[$ii] = &$param;
                }
            }

            // Check if there are enouh bind params
            if (strlen($types) != count($args_as_ref)) {
                return $this->error(302, 'Length of `types` and `bind_params` does not match.');
            }

            // Doesn't work if it is in the loop for some reason
            array_unshift($args_as_ref, $types);

            /* Bind params */
            call_user_func_array(array($stmt, 'bind_param'), $args_as_ref);
            if ($stmt->errno) {
                return $this->error($stmt->error, $stmt->connect_error);
            }
        }

        $this->stmt_active = true;
        $this->stmt = $stmt;

        if ($this->ref_binded_stmt == false) {
            $this->execute();
        }

        return $this;
    }

    public function execute(): int
    {
        /* Execute statement */
        $this->stmt->execute();
        if ($this->stmt->errno) {
            return $this->error($this->stmt->errno, $this->stmt->error);
        }

        return 0;
    }

    public function fetch_all(int $mode = MYSQLI_NUM): array|int
    {
        if ($this->stmt_active == false) {
            return $this->error(301, 'DB::fetch_all() failed: No active statement');
        }

        $result = $this->stmt->get_result();
        if ($result == false) {
            return $this->error(302, 'mysqli_stmt::get_result() failed: ' . $this->stmt->error);
        }

        $results =  $result->fetch_all($mode);

        if ($this->ref_binded_stmt == false) {
            $this->close_stmt();
        }

        return $results;
    }

    public function affected_rows(): int
    {
        if ($this->stmt_active == false) {
            $this->error(301, 'DB::fetch_all() failed: No active statement');
            // This is a bit annoying
            return 0;
        }

        return $this->stmt->affected_rows;
    }
}
