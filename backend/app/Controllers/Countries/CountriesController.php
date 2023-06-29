<?php

namespace App\Controllers\Countries;

use App\Models\Countries\CountriesModel;

class CountriesController
{



    /*
            funcion para obtener todos los registros
    */

    public function getAllCountries()
    {
        try {
            $countries = CountriesModel::get();
            echo json_encode($countries);
            return;
        } catch (\Throwable $th) {
            echo json_encode(['error'=> $th]);
        }
    }

    
    /* 
            funcion para inserta un registro  
    */
    public function insertCountry()
    {
        try {
            
            $datos = json_decode(file_get_contents('php://input'),true);

            $attribute = ['name_country'];
             // verificamos que los atributos no sean vacios y que tengan el nombre corecto
             foreach ($attribute as $key) {
                if (!isset($datos[$key]) || empty(trim($datos[$key]))) {
                    http_response_code(400);
                    echo  json_encode(['error-message' => "Atributos incorrecto o Valores vacios"]);
                    return;
                }
            }

            // verificamos que no hayan atributos que no corresponden al modelo
            $extraKey = array_diff(array_keys($datos), $attribute);
            if (!empty($extraKey)) {
                http_response_code(400);
                echo  json_encode(['error-message' => "Atributos que no corresponden al modelo"]);
                return;
            }

            $country = new CountriesModel(...$datos);
            if ($country->save()) {
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
            echo json_encode(['error'=> $th]);
        }
    }




    /*
            funcion de actualizzar
    */

    public function updateCountry($id)
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);
            $update_country = CountriesModel::Find($id);

            if (isset($update_country)) {
                $update_country->name_country = $datos['name_country'];
                if ($update_country->update()) {
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
            echo json_encode(['error'=> $th]);
        }
    }
    



    /* 
        funcion para eliminar un registro  
    */
    public function deleteCountry($id)
    {
        $update_country = CountriesModel::Find($id);
        if (isset($update_country)) {
            if ($update_country->delete()) {
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
    }


}
?>