<?php

namespace App\Controllers\Journey;

use App\Models\Journey\JourneyModel;

class JourneyController
{

    /*
        funcion para cargar los registros
    */
    public function getAllJourneys()
    {
        try {
            $journey = JourneyModel::get();
            echo json_encode($journey);
            return;
        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }


    /* 
        funcion para insertar un registro 
    */
    public function  insertJourney()
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);

            $attribute = ['name_journey','check_in','check_out'];
            // verificamos que los atributos no sean vacios y que tengan el nombre corecto
            foreach ($attribute as $key) {
                if (!isset($datos[$key]) || empty(trim($datos[$key]))) {
                    http_response_code(400);
                    echo  json_encode([
                        'error-message' => "Atributos incorrecto o Valores vacios"
                    ]);
                    return;
                }
            }
            // verificamos que no hayan atributos que no corresponden al modelo
            $extraKey = array_diff(array_keys($datos), $attribute);
            if (!empty($extraKey)) {
                http_response_code(400);
                echo  json_encode([
                    'error-message' => "Atributos que no corresponden al modelo"
                ]);
                return;
            }

            // si llega valido en true , se guarda
            $journey = new JourneyModel(...$datos);
            if ($journey->save()) {
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


    /*
            funcion para actualizar un registro 
    */
    public function updateJourney($id)
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);

            $oldJourney = JourneyModel::Find($id);

            if (isset($oldJourney)) {
                $oldJourney->name_journey = $datos['name_journey'];
                $oldJourney->check_in = $datos['check_in'];
                $oldJourney->check_out = $datos['check_out'];
                
                if ($oldJourney->update()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'Actualizado correctamente'
                    ]);
                    return;
                }

                http_response_code(304);
                echo json_encode([
                    'message' => 'Actualizacion fallida'
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
     *      funcion para eliminar un registro 
    */
    public function deleteJourney($id)
    {
        try {
            $journey = JourneyModel::Find($id);   
            if ($journey) {
                
                if($journey->delete()){
                    http_response_code(200);
                    echo json_encode(['message'=> 'eliminado correctamente']);
                    return;
                }
                http_response_code(400);    
                echo json_encode(['message' => 'eliminacion fallida']);
                return;
            }

            http_response_code(404);
            echo json_encode(['message'=> 'El registro que intenta eliminar no existe']);
            return;
        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th->getMessage()]);
        }
    }




}

?>


