<?php

namespace Routes;

use Dotenv\Dotenv;
use Bramus\Router\Router;


// Router
$router = new Router();
$dotenv = Dotenv::createImmutable('./config/env/');
$dotenv->load();



// rutas para areas
$router->mount('/api/areas', function() use($router){
    // ruta para obtener todas las areas
    $router->get('/','App\Controllers\Areas\AreasController@getAllAreas');
    // ruta para crear una categoria 
    $router->post('/','App\Controllers\Areas\AreasController@insertArea');
    // ruta para actualizar una Area
    $router->post('/{id}','App\Controllers\Areas\AreasController@updateArea');
    // ruta para eliminar un Area
    $router->delete('/{id}','App\Controllers\Areas\AreasController@deleteArea');
}); 



// rutas para position
$router->mount('/api/position',function() use($router){
    // ruta  para obtener todas las positions
    $router->get('/', 'App\Controllers\Position\PositionController@getAllPositions');
    // ruta para agregar un registro en tabla position 
    $router->post('/', 'App\Controllers\Position\PositionController@insertPosition');
    // ruta para actualizar un registro de la tabla  position
    $router->post('/{id}','App\Controllers\Position\PositionController@updatePositon');
    //ruta para eliminar un registro de la tabla position
    $router->delete('/{id}','App\Controllers\Position\PositionController@deletePosition');
});

















$router->run();
?>