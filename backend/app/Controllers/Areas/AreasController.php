<?php

namespace App\Controllers\Areas;

use App\Models\Areas\Areas;

class AreasController
{



    /*
            funcion que retorna todos los registros 
            de areas existentes en la base de datos 
    */
    public function getAllAreas()
    {
        try {
            $areas = Areas::getAllAreas();
            echo json_encode($areas);
            return;
        } catch (\Throwable $e) {
            echo  json_encode(['error' => $e->getMessage()]);
        }
    }


    /*  
            funcion que valida que el nombre del atributo 
            sea correcto y su valor no este vacio
            si se cumplen esas condiciones procede a realizar
            el guardado del registro , usando el metodo save
            propio del modelo
    */
    public function insertArea()
    {
        try {
            $name_area = json_decode(file_get_contents('php://input'), true);

            if (!isset($name_area['name_area']) || empty(trim($name_area['name_area']))) {
                echo json_encode([
                    'error' => "El atributo no existe o valor esta vacio",
                ]);
                return;
            }


            $area = new Areas(...$name_area);
            if ($area->save()) {
                http_response_code(201);
                echo json_encode([
                    'message' => 'creado correctamente',
                ]);
                return;
            }
            
        } catch (\Throwable $th) {
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }



    /* 
            funcion que valida si el registro existe
            y si existe y las propiedades son correctas
            entonces procede a actualizar el registro 
            usando el metodo update, propio del modelo.
    */
    public function updateArea($id)
    {
        try {

            $oldArea = Areas::Find($id);
            if (isset($oldArea)) {    
                $oldArea->name_area = $_POST['name_area'];
                if ($oldArea->update()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => "actualizado correctamente"
                    ]);
                    return;
                } else {
                    http_response_code(304);
                    echo json_encode([
                        'message' => 'No se actualizo el registro'
                    ]);
                    return;
                }
            }

            http_response_code(404);
            echo json_encode([
                'message' => "No Existe el registro con id: $id"
            ]);
            return;
            
        } catch (\Throwable $th) {
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }



    /* 
            funcion que valida si el registro existe 
            y si existe entonces procede a eliminarlo
            usando la el metodo delete, propio del modelo.
    */
    public function deleteArea($id)
    {
        try {
            $existingArea = Areas::Find($id);
            if (isset($existingArea)) {
                if ($existingArea->delete()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $existingArea->toString() 
                    ]);
                    return;
                }
            }

            http_response_code(404);
            echo json_encode([
                'message' => "No se puede eliminar, El registro no existe"
            ]);               
            return;
        } catch (\Throwable $th) {
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }




}

?>