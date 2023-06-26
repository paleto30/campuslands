<?php

namespace App\Controllers\Levels;

use App\Models\Levels\LevelsModel;

class LevelsController
{




    /*
            funcion para obtener todos los registros
    */

    public function getAllLevels()
    {
        try {
            $levels = LevelsModel::get();
            echo json_encode($levels);
            return;
        } catch (\Throwable $th) {
           echo json_encode(['error'=> $th->getMessage()]);
        }
    }


    /* 
            funcion para insertar un registro
    */
    public function insertLevel()
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);

            $attributes = ['name_level','group_level'];
            // verificamos que los atributos no sean vacios y que tengan el nombre corecto
            foreach ($attributes as $key) {
                if (!isset($datos[$key]) || empty(trim($datos[$key]))) {
                   
                    http_response_code(400);
                    echo  json_encode([
                        'error-message' => "Atributos incorrecto o Valores vacios"
                    ]);
                    return;
                }
            
            }
            
            // verificamos que no hayan atributos que no corresponden al modelo
            $extraKey = array_diff(array_keys($datos), $attributes);
            if (!empty($extraKey)) {
                
                http_response_code(400);
                echo  json_encode([
                    'error-message' => "Atributos que no corresponden al modelo"
                ]);
                return;
            }

            // si llega valido en true , se guarda
            $level = new LevelsModel(...$datos);
            if ($level->save()) {
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
    public function updateLevel($id)
    {   
        try {
            $datos = json_decode(file_get_contents('php://input'),true);

            $oldLevel = LevelsModel::Find($id);
            if (isset($oldLevel)) {
                $oldLevel->name_level = $datos['name_level'];
                $oldLevel->group_level = $datos['group_level'];

                if ($oldLevel->update()) {
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



    /* 
                funcion para eliminar un regitro 
    */
    public function deleteLevel($id)
    {
        try {
            $exintingLevel = LevelsModel::Find($id);

            if (isset($exintingLevel)) {
                if ($exintingLevel->delete()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $exintingLevel->toString() 
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