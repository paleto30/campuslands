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
            } else {

                $area = new Areas(...$name_area);
                if ($area->save()) {
                    $status = 201;
                    http_response_code($status);
                    echo json_encode([
                        'message' => 'creado correctamente',
                    ]);
                }
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
                    echo json_encode([
                        'message' => "actualizado correctamente"
                    ]);
                } else {
                    echo json_encode([
                        'message' => 'No se actualizo el registro'
                    ]);
                }
            }else{
                echo json_encode([
                    'message' => "No Existe el registro con id: $id"
                ]);
            }
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
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $existingArea->toString() 
                    ]);
                }
            }else{
                echo json_encode([
                    'message' => "No se puede eliminar, El registro no existe"
                ]);
            }
        } catch (\Throwable $th) {
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }




}

?>