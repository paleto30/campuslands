<?php

namespace App\Controllers\Regions;

use App\Models\Regions\RegionModel;

class RegionController
{

    /* 
        funcion para obtener todos los registros
    */
    public function getAllRegions()
    {
        try {
            $regions = RegionModel::get();
            echo json_encode($regions);
            return;
        } catch (\Throwable $th) {
            echo  json_encode(['error'=>$th->getMessage()]) ;
        }
    }




    /*
        cuncion para insertar un registro 
    */
    public function insertRegion()
    {
        try {
            
            $datos = json_decode(file_get_contents('php://input'),true);
            

            $atribute = ['name_region','id_country'];
            // verificamos que los atributos no sean vacios y que tengan el nombre corecto
            foreach ($atribute as $key) {
                if (!isset($datos[$key]) || empty(trim($datos[$key]))) {
                    http_response_code(400);
                    echo  json_encode(['error-message' => "Atributos incorrecto o Valores vacios"]);
                    return;
                }
            }
            // verificamos que no hayan atributos que no corresponden al modelo
            $extraKey = array_diff(array_keys($datos), $atribute);
            if (!empty($extraKey)) {
                http_response_code(400);
                echo  json_encode(['error-message' => "Atributos que no corresponden al modelo"]);
                return;
            }

            // si llega valido en true , se guarda
            
            $region = new RegionModel(...$datos);
            if ($region->save()) {
                http_response_code(201);
                echo json_encode(['message'=> 'creado correctamente']);
                return;
            }

            http_response_code(400);
            echo json_encode(['error-message' => 'NO se a creado el registro']);
            return;
            
        } catch (\Throwable $th) {
            echo  json_encode(['error'=>$th->getMessage()]) ;
        }
    }


    /*
            funcion para actualizar  un registro 
    */
    public function updateRegion($id)
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);
            $region = RegionModel::Find($id);

            if (isset($region)) {
                $region->name_region = $datos['name_region'];
                $region->id_country = $datos['id_country'];
                if ($region->update()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Actualizado correctamente']);
                    return;
                }
                http_response_code(304);
                echo json_encode(['message' => 'Actualizacion fallida']);
                return;
            }
            http_response_code(404);
            echo json_encode(['error-message' => "El Registro id : $id no Existe"]);
            return;

        } catch (\Throwable $th) {
            echo  json_encode(['error'=>$th->getMessage()]) ;
        }
    }


    /* 
            funcion para eliminar un registro 
    */
    public function deleteRegion($id)
    {
        try {
            $region = RegionModel::Find($id);
            if (isset($region)) {
                if ($region->delete()) {
                    http_response_code(200);
                    echo json_encode(['message' => 'eliminado correctamente']);
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
            echo  json_encode(['error'=>$th->getMessage()]) ;
        }
    }


}

?>