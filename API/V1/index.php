<?php

use databases\Database;

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "../../".$class) . '.php';
});

// $limit = $_GET['limit'];

if (isset($_GET['limit'])) {
    getTopWatchedAnimeList($_GET['limit']);
}

function getTopWatchedAnimeList(int $limit){
    $database = new Database();
    $database->getLimitedTopWatchedAnime($limit);
}

// var_dump($database);
// print_r($database);
// echo $database->asXML();