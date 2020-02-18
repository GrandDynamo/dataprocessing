<?php

namespace factories;

use classes\{fileManager\readers\ReadSettings, queryLanguages\MySQL};

use mysqli;
use classes\parsers\XMLParser;

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});

class APIFactory
{
    private mysqli $connection;
    private array $dbSettings;

    public function __construct()
    {
        $this->loadDatabaseSettings();
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
        $this->dbSettings = $readSettings->getSettingsInCategory('databaseConnection');
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
     * @param [type] ...$queryParams
     * @return void
     */
    public function getXMLFromQuery(string $query, array $nodeNames, ...$queryParams)
    {
        $mySQL = new MySQL($this->connection);
        $mySQL->executeQuery($query, ...$queryParams);
        // echo "<pre>";
        // var_dump($mySQL->getResult());
        // echo "</pre>";
        $parse = new XMLParser();
        $array = $mySQL->getResult();
        $parse->parseArray($array, array());
    }
}
