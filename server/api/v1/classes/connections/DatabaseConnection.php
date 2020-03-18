<?php
namespace classes\connections;

use Exception;
use mysqli;
use mysqli_driver;

class DatabaseConnection
{
    public ?mysqli $connection;

    public function __construct(string $host, string $user, string $password, string $databaseName)
    {
        $this->establishConnection($host, $user, $password, $databaseName);
        return $this->connection;
    }

    public function establishConnection(string $host, string $user, string $password, string $databaseName): void
    {
        //Mysqli has build in error checking when created.
        $this->connection = new mysqli($host, $user, $password, $databaseName);
    }

    public function getConnection(): DatabaseConnection
    {
        return $this;
    }
}
