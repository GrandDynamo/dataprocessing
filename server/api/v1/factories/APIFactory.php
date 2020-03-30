<?php

namespace factories;

use classes\{fileManager\readers\ReadSettings, queryLanguages\MySQL};
use classes\parsers\{JSONParser, XMLParser};
use mysqli;

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});

class APIFactory
{
    private mysqli $connection;
    private array $dbSettings;
    private array $querySetting;

    public function __construct()
    {
        $this->loadDatabaseSettings();
        $this->loadQuerySettings();
        $this->establishDatabaseConnection();
    }

    /**
     * Loads the settings inside a var to be used for database connections.
     *
     * @return void
     */
    private function loadDatabaseSettings(): void
    {
        $readSettings = new ReadSettings();
        $readSettings->readFile('settings.json');

        $this->dbSettings = ($readSettings->getSettingsArray())['dbConnectionSettings'];
    }
    /**
     * Loads the queries including 
     *
     * @return void
     */
    private function loadQuerySettings(): void
    {
        $readSettings = new ReadSettings();
        $readSettings->readFile('settings.json');
        $xmlsettings = $readSettings->getSettingsArray();
        $this->querySetting = $xmlsettings['querySettings'];
    }

    /**
     * Establishes a connection with a database.
     *
     * @return void
     */
    private function establishDatabaseConnection(): void
    {
        $this->connection = new mysqli(
            $this->dbSettings['host'],
            $this->dbSettings['userName'],
            $this->dbSettings['password'],
            $this->dbSettings['name']
        );
    }

    /**
     * Can be used to execute Idempotent queries that are safe.
     * For example: GET.
     * And calls the appropiate method for returning content.
     *
     * @param string $queryName
     * @param mixed ...$queryParams
     * @return void
     */
    public function executeSafeIdempotentQuery(string $queryName, ...$queryParams)
    {
        $requestedContentType = $_SERVER['HTTP_CONTENT_TYPE'];
        if ($requestedContentType == "application/json") {
            $this->getJSONFromQuery($queryName, ...$queryParams);
            return;
        } else {
            $this->getXMLFromQuery($queryName, ...$queryParams);
            return;
        }
        return;
    }

    /**
     * Returns the name of a validation schema if it exists in the settings.json
     * When not present in the settings file return nothing.
     *
     * @param string $queryName
     * @return null|string
     */
    private function getSchemaName($queryName): ?string
    {
        if (isset($this->querySetting[$queryName]['schemaName'])) {
            return $this->querySetting[$queryName]['schemaName'];
        }
        return null;
    }

    /**
     * Retrieves a XML structured string from a query.
     *
     * @param string $query
     * @param mixed ...$queryParams
     * @return void
     */
    private function getXMLFromQuery(string $queryName, ...$queryParams)
    {
        $mySQL = new MySQL($this->connection);
        $execution = $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryParams);
        if (!$execution) {
            die();
        }
        $array = $mySQL->getResult();
        $parse = new XMLParser($this->querySetting[$queryName]['XMLSettings']['rootNodeName'], $this->querySetting[$queryName]['XMLSettings']['groupedNodeName'], $this->getSchemaName($queryName));
        $parse->parseArray($array);
        //Sending header information.
        header('Content-Type: application/xml; charset=utf-8');
        echo $parse->getParsedContent();
    }

    /**
     * Retrieves a JSON structured string from a query.
     *
     * @param string $query
     * @param mixed ...$queryParams
     * @return void
     */
    private function getJSONFromQuery(string $queryName, ...$queryParams)
    {

        $mySQL = new MySQL($this->connection);
        $execution = $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryParams);
        if (!$execution) {
            die();
        }
        $parse = new JSONParser();
        $array = $mySQL->getResult();
        $parse->parseArray($array);
        //Header to return schema location to the consumer.
        header('Link: http://localhost/dataprocessing/server/api/v1/schemas/draft-07/' . $queryName . '.json');
        header("Content-type: application/json; charset=utf-8");
        echo $parse->getParsedContent();
    }

    /**
     * Can be used to execute Idempotent queries that are not safe. 
     * For example: PUT and DELETE.
     *
     * @param string $queryName
     * @param mixed ...$queryParams
     * @return void
     */
    public function executeNonSafeIdempotentQuery(string $queryName, $id, ...$queryParams)
    {

        foreach ($queryParams as $key => $value) {
            foreach ($value as $key => $nestedValue) {
                $queryArray[] = $nestedValue;
            }
        }

        //Check if ...$queryParams contains an array to use correct $id nesting depth.
        if (count($queryParams) === 0) {
            $queryArray[] = $id;
        } elseif (count($queryParams) === 1) {
            $queryArray[] = $id[0];
        }
        $mySQL = new MySQL($this->connection);
        $execution = $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryArray);
        //Return appropiate header for PUT or DELETE.
        if ($execution === false) {
            if (count($queryParams) === 0) {
                header("HTTP/1.0 404 Not Found");
            } elseif (count($queryParams) === 1) {
                // header("HTTP/1.0 204 No Content");
            }
        }
    }

    /**
     * Can be used to execute Non-Idempotent queries that are not safe.
     * For example: POST.
     *
     * @param string $queryName
     * @param mixed ...$queryParams
     * @return void
     */
    public function executeNonSafeNonIdempotentQuery(string $queryName, $queryParams)
    {
        foreach ($queryParams as $key => $value) {
            $queryArray[] = $value;
        }

        $mySQL = new MySQL($this->connection);
        $returnedBool = $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryArray);
        if ($returnedBool === true) {
            // header("HTTP/1.0 204 No Content");
        }
    }
}
