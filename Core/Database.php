<?php

/**
 * File Name: Database.php
 * Description: Manages database connections and queries.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

use PDO;

class Database
{
    public $connection;

    public $statement;

    public function __construct($config, $username = 'root', $password = '') {

        // $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};user=root;charset={$config['charset']}";
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = []) {
        // $this->statement adds statement as a property of the current instance of the Database object
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function find() {
        return $this->statement->fetch();
    }

    public function findOrFail() {
        $result = $this->find();

        if (! $result) {
            abort();
        }

        return $result;
    }
}