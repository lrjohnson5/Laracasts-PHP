<?php

declare(strict_types=1);

/**
 * File Name: Database.php
 * Description: Manages database connections and queries.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types and improved security
 */

namespace Core;

use PDO;
use PDOStatement;

class Database
{
    public PDO $connection;
    public PDOStatement $statement;

    public function __construct(array $config, string $username = 'root', string $password = '')
    {
        // $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};user=root;charset={$config['charset']}";
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function query(string $query, array $params = []): self
    {
        // $this->statement adds statement as a property of the current instance of the Database object
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function get(): array
    {
        return $this->statement->fetchAll();
    }

    public function find(): mixed {
        return $this->statement->fetch();
    }

    public function findOrFail(): mixed
    {
        $result = $this->find();

        if (!$result) {
            abort();
        }

        return $result;
    }
}