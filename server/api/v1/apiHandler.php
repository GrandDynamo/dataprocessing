<?php

use factories\APIFactory;
use classes\routing\{Request, Router};

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});
$router  = new Router(new Request());


// $router->get('/dataprocessing/api/v1/animes/{num}/wow/{idk}', function () {
//     return "Routed into option: <b>1</b>";
// });


//Used to inject the object into the callback function.
$apiFactory = new APIFactory();
$router->get('/dataprocessing/api/v1/anime/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->getJSONFromQuery("getAnime", $id);
});
$router->get('/dataprocessing/api/v1/topanime/{limit}', function ($limit) use ($apiFactory) {
    return $apiFactory->getJSONFromQuery("getTopWatchedAnime", $limit);
});
$router->get('/dataprocessing/api/test/{ok}', function () use ($apiFactory) {
    return "Routed into option: <b>4</b>";
});
$router->get('/dataprocessing/api/wow/{id}', function () use ($apiFactory) {
    return "Routed into option: <b>5</b>";
});
$router->get('/dataprocessing/api/nani/', function () use ($apiFactory) {
    return "Routed into option: <b>6</b>";
});
$router->get('/dataprocessing/api/v1/animes/{num}/wow/{idk}/wow', function () use ($apiFactory) {
    return "Routed into option: <b>7</b>";
});
$router->get('/dataprocessing/api/test/{nice}', function () use ($apiFactory) {
    return "Routed into option: <b>8</b>";
});






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
