<?php

namespace factories;

use classes\{fileManager\readers\ReadSettings, queryLanguages\MySQL};
use classes\parsers\JSONParser;
use mysqli;
use classes\parsers\XMLParser;

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

        $this->dbSettings = ($readSettings->getSettingsArray())['databaseConnection'];
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
     * Retrieves a XML structured string from a query.
     *
     * @param string $query
     * @param mixed ...$queryParams
     * @return void
     */
    // public function getXMLFromQuery(string $query, array $XMLNodes, ...$queryParams)
    public function printXMLFromQuery(string $queryName, ...$queryParams)
    {
        $mySQL = new MySQL($this->connection);
        $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryParams);
        // echo "<pre>";
        // var_dump($mySQL->getResult());
        // echo "</pre>";
        $parse = new XMLParser();
        $array = $mySQL->getResult();
        $parse->parseArray($array, $this->querySetting[$queryName]['groupedNode']);
        echo $parse->getParsedContent();
        header('Content-Type: application/xml; charset=utf-8');
    }

    /**
     * Retrieves a JSON structured string from a query.
     *
     * @param string $query
     * @param mixed ...$queryParams
     * @return void
     */
    public function printJSONFromQuery(string $queryName, ...$queryParams)
    {
        $mySQL = new MySQL($this->connection);
        $mySQL->executeQuery($this->querySetting[$queryName]['query'], ...$queryParams);
        // echo "<pre>";
        // var_dump($mySQL->getResult());
        // echo "</pre>";
        $parse = new JSONParser();
        $array = $mySQL->getResult();
        $parse->parseArray($array);
        header("Content-type: application/json; charset=utf-8");
        echo $parse->getParsedContent();
        
    }
}
