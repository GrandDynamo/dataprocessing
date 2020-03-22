<?php

use factories\APIFactory;
use classes\routing\{Request, Router};

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});



$router  = new Router(new Request());

//Used to inject the object into the callback function.
$apiFactory = new APIFactory();
$router->get('/dataprocessing/api/v1/anime/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->getJSONFromQuery("getAnime", $id);
});
$router->post('/dataprocessing/api/v1/anime/', function ($request) use ($apiFactory) {
    $apiFactory->executeNonSafeNonIdempotentQuery("addAnime", $request->getBody());
    return;
});
$router->get('/dataprocessing/api/v1/animeratings/{animeid}/{higherthen}', function ($animeRatings, $higherThen) use ($apiFactory) {
    return $apiFactory->getJSONFromQuery("getAnimeRatings", $animeRatings, $higherThen);
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
