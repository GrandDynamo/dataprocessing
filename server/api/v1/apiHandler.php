<?php

use factories\APIFactory;

$categories = array('animeData', 'userData');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
if (!in_array($uri[4], $categories)) {
    header('HTTP/1.1 400 Bad request - Something in wrong with the URL.', true, 400);
    die('The category ' . $uri[4] . ' does not exist.');
}
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
// var_dump(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
// echo "</pre>";




// APIFactory::setDatabaseConnection();
// APIFactory::setDatabaseConnection();
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
$apiFactory->getXMLFromQuery("SELECT anime_id, COUNT(ratinglist.user_id) AS bruh
FROM `ratinglist` 
GROUP BY ratinglist.anime_id
ORDER BY bruh DESC", array('toberemoved'));
