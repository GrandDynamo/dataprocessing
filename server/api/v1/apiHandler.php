<?php

use factories\APIFactory;
use classes\routing\{Request, Router};

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});

var_dump(apache_request_headers());
$router  = new Router(new Request());

//Used to inject the object into the callback function.
$apiFactory = new APIFactory();
$router->get('/dataprocessing/api/v1/animes/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnime", $id);
});
$router->get('/dataprocessing/api/v1/animes/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnimes");
});
$router->post('/dataprocessing/api/v1/anime/', function ($request) use ($apiFactory) {
    return $apiFactory->executeNonSafeNonIdempotentQuery("addAnime", $request->getBody());
});
$router->get('/dataprocessing/api/v1/animeratings/{animeid}/{higherthen}', function ($animeRatings, $higherThen) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnimeRatings", $animeRatings, $higherThen);
});
$router->put('/dataprocessing/api/v1/anime/{id}', function ($request, $id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("updateAnime", $id, $request->getBody());
});
$router->delete('/dataprocessing/api/v1/anime/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("deleteAnime", $id);
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
