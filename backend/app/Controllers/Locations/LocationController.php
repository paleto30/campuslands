<?php

namespace App\Controllers\Locations;

use App\Models\Locations\LocationModel;

class LocationController{



    /**
     *          funcsion para  obtenner todos los registros
    */
    public function getAllLocations()
    {
        try {
            $locations = LocationModel::get();
            echo json_encode($locations);
            return;
        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }


    /**
     *  funcion para insertar un registro 
    */
    public function insertLocation()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"),true);
            
            $atribute = ['name_location'];
    
            // verificamos que los atributos no sean vacios y que tengan el nombre corecto
            foreach ($atribute as $key) {
                if (!isset($datos[$key]) || empty(trim($datos[$key]))) {
                    http_response_code(400);
                    echo  json_encode([
                        'error-message' => "Atributos incorrecto o Valores vacios"
                    ]);
                    return;
                }
            }
            // verificamos que no hayan atributos que no corresponden al modelo
            $extraKey = array_diff(array_keys($datos), $atribute);
            if (!empty($extraKey)) {
                http_response_code(400);
                echo  json_encode([
                    'error-message' => "Atributos que no corresponden al modelo"
                ]);
                return;
            }

            // si llega valido en true , se guarda
            $location = new LocationModel(...$datos);
            if ($location->save()) {
                http_response_code(201);
                echo json_encode(['message'=> 'creado correctamente']);
                return;
            }

            http_response_code(400);
            echo json_encode([
                'error-message' => 'NO se a creado el registro'
            ]);
            return;
     

        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }


    /**
     *          funcion para actualizar un registro
    */
    public function updateLocation($id)
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);
        
            $oldLocation = LocationModel::Find($id);
            if (isset($oldLocation)) {                
                $oldLocation->name_location = $datos['name_location'];
                if ($oldLocation->update()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'Actualizado correctamente'
                    ]);
                    return;
                }
                http_response_code(304);
                echo json_encode([
                    'message' => 'Actualizado correctamente'
                ]);
                return; 
            }

            http_response_code(404);
            echo json_encode([
                'message' => "El registro id:$id no existe"
            ]);               
            return;

        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }


    /**
     *          funcion para elimnar un registro 
    */
    public function deleteLocation($id)
    {
        try {
            $existingLocation = LocationModel::Find($id);
            if (isset($existingLocation)) {
                if ($existingLocation->save()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $existingLocation->toString() 
                    ]);
                    return;
                }
            }
            http_response_code(404);
            echo json_encode([
                'error-message' => "No puedes eliminar un registor que no existe"
            ]);               
            return;
            
        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }



}
?>