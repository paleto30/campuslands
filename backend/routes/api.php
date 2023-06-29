<?php

namespace Routes;

use Dotenv\Dotenv;
use Bramus\Router\Router;


// Router
$router = new Router();
$dotenv = Dotenv::createImmutable('./config/env/');
$dotenv->load();



// rutas para areas   1
$router->mount('/api/areas', function() use($router){
    // ruta para obtener todas las areas
    $router->get('/','App\Controllers\Areas\AreasController@getAllAreas');
    // ruta para crear una categoria 
    $router->post('/','App\Controllers\Areas\AreasController@insertArea');
    // ruta para actualizar una Area
    $router->put('/{id}','App\Controllers\Areas\AreasController@updateArea');
    // ruta para eliminar un Area
    $router->delete('/{id}','App\Controllers\Areas\AreasController@deleteArea');
}); 



// rutas para position 2
$router->mount('/api/position',function() use($router){
    // ruta  para obtener todas las positions
    $router->get('/', 'App\Controllers\Position\PositionController@getAllPositions');
    // ruta para agregar un registro en tabla position 
    $router->post('/', 'App\Controllers\Position\PositionController@insertPosition');
    // ruta para actualizar un registro de la tabla  position
    $router->put('/{id}','App\Controllers\Position\PositionController@updatePositon');
    //ruta para eliminar un registro de la tabla position
    $router->delete('/{id}','App\Controllers\Position\PositionController@deletePosition');
});



//rutas para Subjects 3
$router->mount('/api/subject',function() use($router){
    // ruta para obtener los registros
    $router->get('/', 'App\Controllers\Subjects\SubjectsController@getAllSubjects');
    // ruta para inserta un registro
    $router->post('/','App\Controllers\Subjects\SubjectsController@insertSubject');
    // ruta para actualizar un regustro 
    $router->put('/{id}','App\Controllers\Subjects\SubjectsController@updateSubject');
    // ruta para borrar un registro
    $router->delete('/{id}','App\Controllers\Subjects\SubjectsController@deleteSubject');
});



// rutas pata Locations 4 
$router->mount('/api/location', function() use($router){
    // ruta para obtener todos los registros
    $router->get('/', 'App\Controllers\Locations\LocationController@getAllLocations');
    // ruta para insertar un registro
    $router->post('/', 'App\Controllers\Locations\LocationController@insertLocation');
    // ruta para actualizar un registro
    $router->put('/{id}', 'App\Controllers\Locations\LocationController@updateLocation');
    // ruta para eliminar un registro 
    $router->delete('/{id}', 'App\Controllers\Locations\LocationController@deleteLocation');
});



// rutas para levels 5 
$router->mount('/api/levels', function() use($router){
    // ruta para obtener todos los registros
    $router->get('/', 'App\Controllers\Levels\LevelsController@getAllLevels');
    // ruta para insertar un registro
    $router->post('/', 'App\Controllers\Levels\LevelsController@insertLevel');
    // ruta para actualizar un registro
    $router->put('/{id}', 'App\Controllers\Levels\LevelsController@updateLevel');
    // ruta para eliminar un registro 
    $router->delete('/{id}', 'App\Controllers\Levels\LevelsController@deleteLevel');
});



//  rutas para Journey 6
$router->mount('/api/journey',function() use($router){
    // ruta pera obtener todos los registros
    $router->get('/','App\Controllers\Journey\JourneyController@getAllJourneys');
    // ruta para insertar un registro
    $router->post('/','App\Controllers\Journey\JourneyController@insertJourney');
    // ruta para actualizar un registro
    $router->put('/{id}','App\Controllers\Journey\JourneyController@updateJourney');
    // ruta para eliminar un registro
    $router->delete('/{id}','App\Controllers\Journey\JourneyController@deleteJourney');
});



// rutas para Countries 7
$router->mount('/api/countries', function ()use($router){
    // ruta para obtener countries
    $router->get('/','App\Controllers\Countries\CountriesController@getAllCountries');
    // ruta para insertar countries
    $router->post('/','App\Controllers\Countries\CountriesController@insertCountry');
    // ruta para actualizar countries
    $router->put('/{id}','App\Controllers\Countries\CountriesController@updateCountry');
    // ruta para eliminar countries
    $router->delete('/{id}','App\Controllers\Countries\CountriesController@deleteCountry');
});





$router->run();
?>