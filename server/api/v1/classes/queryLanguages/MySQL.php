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
     * Execute a Mysql query with Mysqli.
     * 
     *
     * @param string $query Mysql query in string form.
     * @param mixed ...$queryParams [Optional] The parameters of a query.
     * @return bool true on success or false on failure.
     */
    public function executeQuery(string $query, ...$queryParams): bool
    {

        if (!$stmt = $this->connection->prepare($query)) {
            die("Error prepare");
        }
        if ($queryParams) {

            //If $queryParams is multidimensional, make it flat.
            if (array_key_exists(1, $queryParams)) {
                if (is_array($queryParams[1])) {
                    $queryParams2 = [];
                    $queryParams2[] = $queryParams[0];
                    for ($i = 0; $i < count($queryParams[1]); $i++) {
                        $queryParams2[] = $queryParams[1][$i];
                    }
                    $queryParams = $queryParams2;
                } else {
                    header("HTTP/1.0 500 Internal Server Error");
                    return false;
                }
            }

            if (!$typesString = $this->createBindingTypeString(...$queryParams)) {
                header("HTTP/1.0 400 Bad Request");
                return false;
            }
            //Checks if number of parameters needed to bind are the same.
            if (!($stmt->param_count === strlen($typesString))) {
                header("HTTP/1.0 400 Bad Request");
                return false;
            }
            if (!$stmt->bind_param($typesString, ...$queryParams)) {
                header("HTTP/1.0 400 Bad Request");
                return false;
            }
        }
        if (!$stmt->execute()) {
            header("HTTP/1.0 500 Internal Server Error");
            return false;
        }
        //If no row is changed return false. Its up to the caller to send correct header.
        if (($stmt->affected_rows) === 0) {
            return false;
        }
        //Checks if querie executed query returns a result set.
        if ($result = $stmt->get_result()) {
            if (!$result->num_rows > 0) {
                header("HTTP/1.0 404 Not Found");
                return false;
            }

            $this->result = $result->fetch_all(MYSQLI_ASSOC);

            /**
             * Uitzoeken welke beter past bij mijn usecase, de array_filter manier die checked of alles null of 0 is 
             * of de in_array manier waarbij er maar 1 value null hoeft te zijn.
             */
            //Check if there is a NULL value returned by MySQL.
            // if(in_array(null, $this->result[0], true)){
            //     header("HTTP/1.0 400 Bad Request");
            //     return false;
            // }

            if (!array_filter($this->result[0])) {
                header("HTTP/1.0 400 Bad Request");
                return false;
            }

            header("HTTP/1.0 200 OK");
            return true;
        }
        header("HTTP/1.0 204 No Content");
        return true;
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
                    header("HTTP/1.0 400 Bad Request");
                    die("Invalid parameter type for query");
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
