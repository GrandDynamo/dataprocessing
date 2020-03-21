<?php

use factories\APIFactory;
use classes\routing\{Request, Router};

$categories = array('topAnime', 'userData', "toptenWatchedAnime");
// $uriArray = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uriArray = parse_url($_SERVER['QUERY_STRING']);

$uriArray = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
// $uriArray = explode('/', trim($_SERVER['QUERY_STRING'], '/'));
// if (!in_array($uriArray[3], $categories)) {
//     header('HTTP/1.1 400 Bad request - Something in wrong with the URL.', true, 400);
//     die('The category ' . $uri[3] . ' does not exist.');
// }
// use connections\Database;

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});

// // $limit = $_GET['limit'];

// if (isset($_GET['limit'])) {
//     getTopWatchedAnimeList($_GET['limit']);
// }

// function getTopWatchedAnimeList(int $limit){
//     $database = new Database();
//     $database->getLimitedTopWatchedAnime($limit);
// }


// var_dump($database);
// print_r($database);
// echo $database->asXML();


// echo "<pre>";
// var_dump($uriArray);
// echo "</pre>";

// echo json_encode($uriArray);

$router  = new Router(new Request);
$router->get('/dataprocessing/api/v1/animes/{num}/wow/{idk}', function () {
    return "Routed into option: <b>1</b>";
});
$router->get('/dataprocessing/api/v1/animes/{id}', function () {
    return "Routed into option: <b>2</b>";
});
$router->get('/dataprocessing/api/test', function () {
    return "Routed into option: <b>3</b>";
});
$router->get('/dataprocessing/api/test/{ok}', function () {
    return "Routed into option: <b>4</b>";
});
$router->get('/dataprocessing/api/wow/{id}', function () {
    return "Routed into option: <b>5</b>";
});
$router->get('/dataprocessing/api/nani/', function () {
    return "Routed into option: <b>6</b>";
});
$router->get('/dataprocessing/api/v1/animes/{num}/wow/{idk}/wow', function () {
    return "Routed into option: <b>7</b>";
});
$router->get('/dataprocessing/api/test/{nice}', function () {
    return "Routed into option: <b>8</b>";
});
$apiFactory = new APIFactory();





// $apiFactory->getXMLFromQuery("SELECT
// count(user_id) AS Total, 
// (SELECT Count(gender)FROM userlist WHERE gender = 'Male') AS Male, 
// (SELECT Count(gender) FROM userlist WHERE  gender = 'Female') AS Female 
// FROM `userlist` 
// GROUP BY Male, Female");

// $query2 = "SELECT ratinglist.anime_id, COUNT(ratinglist.user_id) AS watched, AVG(ratinglist.rating) AS rating, animelist.name
// FROM `ratinglist` JOIN animelist ON ratinglist.anime_id = animelist.anime_id
// GROUP BY ratinglist.anime_id 
// ORDER BY `watched` DESC
// LIMIT ?";
// $apiFactory->getXMLFromQuery($query2, 10);

// $apiFactory->getXMLFromQuery("SELECT name FROM animelist WHERE anime_id > 1 LIMIT ?", 10);

// $apiFactory->getJSONFromQuery("getUserRatings", 10044);


// $apiFactory->getJSONFromQuery("getTopWatchedAnime", 12);
// $apiFactory->getJSONFromQuery("addAnime");


// $apiFactory->printJSONFromQuery("totalMaleFemaleWeebs");
