<?php

// *  Configurar encabezados CORS  *

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // ->  Este encabezado especifica los métodos HTTP permitidos para las solicitudes. En este caso, se permiten los métodos GET, POST y OPTIONS. Puedes ajustar esta lista según tus necesidades.
// header("Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With, Accept"); -> : Este encabezado especifica los encabezados personalizados permitidos en las solicitudes. Aquí se incluyen algunos ejemplos comunes como Origin, Content-Type, X-Requested-With y Accept. Puedes agregar o quitar encabezados según tus requisitos.
require_once './vendor/autoload.php';
require_once './routes/api.php';


?>
