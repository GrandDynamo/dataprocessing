<?php

use factories\APIFactory;
use classes\routing\{Request, Router};

spl_autoload_register(function ($class) {
    require str_replace("\\", '/', "" . $class) . '.php';
});

$router  = new Router(new Request());

//Used to inject the object into the callback function.
$apiFactory = new APIFactory();

/**
 * GET
 */
$router->get('/dataprocessing/api/v1/animes/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnime", $id);
});

/**
 * FIXED, but needs to be tested more with more variable lookalikes.
 */
$router->get('/dataprocessing/api/v1/animeratings/{animeid}/{higherthen}', function ($animeRatings, $higherThen) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnimeRatings", $animeRatings, $higherThen);
});

$router->get('/dataprocessing/api/v1/animes/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnimes");
});

/**
 * @todo Need to add a new query and route that returns all animes when no ID is given.
 */
$router->get('/dataprocessing/api/v1/topanimes/{amount}', function ($amount) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getTopWatchedAnime", $amount);
});
/**
 * @todo Need to add a new query and route that returns all animes when no ID is given.
 */
$router->get('/dataprocessing/api/v1/animes/{animeid}/gendercomparison/', function ($animeId) use ($apiFactory) {
    //Due to how this query works and the backend is designed, i create copies of the user input and place them in an array.
    $animeId2 = [];
    $animeId3 = $animeId;
    array_push($animeId2, $animeId3, $animeId3, $animeId3);
    return $apiFactory->executeSafeIdempotentQuery('getNumberOfMaleFemaleUsers', $animeId, $animeId2);
});

$router->get('/dataprocessing/api/v1/animeuserstats/{animeid}', function ($animeId) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery('getAnimeUserStatistics', $animeId);
});


/**
 * POST
 */
$router->post('/dataprocessing/api/v1/anime/', function ($request) use ($apiFactory) {
    return $apiFactory->executeNonSafeNonIdempotentQuery("addAnime", $request->getBody());
});


/**
 * PUT
 */
$router->put('/dataprocessing/api/v1/anime/{id}', function ($request, $id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("updateAnime", $id, $request->getBody());
});


/**
 * DELETE
 */
$router->delete('/dataprocessing/api/v1/anime/{id}', function ($id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("deleteAnime", $id);
});
