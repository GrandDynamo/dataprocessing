<?php

namespace classes\queryLanguages;

use mysqli;

/**
 * Represents a connection between PHP and mysqli.
 */
class MySQL
{
    private mysqli $connection;
    private array $result = array();
    private $test;

    /**
     * Uses the mysqli connection to execute queries.
     *
     * @param mysqli $connection The mysqli connection.
     */
    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Executes a SQL query.
     *
     * @param string $query Mysql query in string form.
     * @param mixed ...$queryParams [Optional] The parameters of a query.
     * @return void
     */
    public function executeQuery(string $query, ...$queryParams): void
    {
        $stmt = $this->connection->prepare($query);
        if ($queryParams) {
            $typesString = $this->createBindingTypeString(...$queryParams);
            $stmt->bind_param($typesString, ...$queryParams);
        }
        $stmt->execute();
        $this->result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Creates a string of parameter types for binding parameters.
     *
     * @param mixed ...$queryParams
     * @return string
     */
    private function createBindingTypeString(...$queryParams): string
    {
        $typesArray = []; //Initializing
        foreach ($queryParams as $key => $value) {
            switch (gettype($value)) {
                case 'integer':
                    array_push($typesArray, 'i');
                    break;
                case 'double':
                    array_push($typesArray, 'd');
                    break;
                case 'string':
                    array_push($typesArray, 's');
                    break;
                case 'boolean':
                    array_push($typesArray, 'b');
                    break;
                default:
                    exit("Invalid parameter type for query");
                    break;
            }
        }

        return $typesArray = implode($typesArray);
    }

    /**
     * Returns the result of the query in an array.
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
