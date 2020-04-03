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
$router->get('/dataprocessing/api/v1/animes/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAllAnimes");
});
$router->get('/dataprocessing/api/v1/animeratings/{animeid}/{higherthen}', function ($animeRatings, $higherThen) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAnimeRatings", $animeRatings, $higherThen);
});
$router->get('/dataprocessing/api/v1/animeratings/{higherthen}', function ($higherThen) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAllAnimeRatings", $higherThen);
});
$router->get('/dataprocessing/api/v1/topanimes/{amount}', function ($amount) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getTopWatchedAnime", $amount);
});
$router->get('/dataprocessing/api/v1/topanimes/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery("getAllTopWatchedAnimes");
});
$router->get('/dataprocessing/api/v1/animes/{animeid}/gendercomparison/', function ($animeId) use ($apiFactory) {
    //Due to how this query works and the backend is designed, i need to create copies of the user input and place them in an array.
    $animeId2 = [];
    array_push($animeId2, $animeId, $animeId, $animeId);
    return $apiFactory->executeSafeIdempotentQuery('getNumberOfMaleFemaleUsers', $animeId, $animeId2);
});
$router->get('/dataprocessing/api/v1/animes/gendercomparison/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery('getAllNumberOfMaleFemaleViewers');
});
$router->get('/dataprocessing/api/v1/animes/{animeid}/users/stats/', function ($animeId) use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery('getAnimeUsersStatistics', $animeId);
});
$router->get('/dataprocessing/api/v1/users/stats/', function () use ($apiFactory) {
    return $apiFactory->executeSafeIdempotentQuery('getAllUsersStatistics');
});

/**
 * POST
 */
$router->post('/dataprocessing/api/v1/anime/', function ($request) use ($apiFactory) {
    return $apiFactory->executeNonSafeNonIdempotentQuery("postAnime", $request->getBody());
});
    
$router->post('/dataprocessing/api/v1/user/', function ($request) use ($apiFactory) {
    return $apiFactory->executeNonSafeNonIdempotentQuery("postUser", $request->getBody());
});


/**
 * PUT
 * 
 * @todo In future versions implement the ability to validate PUTS.
 */
$router->put('/dataprocessing/api/v1/anime/{id}', function ($request, $id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("updateAnime", $id, $request->getBody());
});

$router->put('/dataprocessing/api/v1/user/{id}', function ($request, $id) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("putUser", $id, $request->getBody());
});


/**
 * DELETE
 * 
 * @todo In future versions implement the ability to validate DELETE.
 */
$router->delete('/dataprocessing/api/v1/anime/{animeid}', function ($animeId) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("deleteAnime", $animeId);
});

$router->delete('/dataprocessing/api/v1/user/{userid}', function ($userId) use ($apiFactory) {
    return $apiFactory->executeNonSafeIdempotentQuery("deleteUser", $userId);
});
