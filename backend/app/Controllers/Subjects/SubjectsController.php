<?php

namespace App\Controllers\Subjects;

use App\Models\Subjects\SubjectsModel;

class SubjectsController
{



    /*
            funcion para retornar los registros de Subjects 
    */
    public function getAllSubjects()
    {
        try {

            $subjects = SubjectsModel::get();
            echo json_encode($subjects);
            return;
        } catch (\Throwable $th) {
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }


    /**
     *      Funcion para insertar un registro
    */
    public function insertSubject()
    {
        try {
            $datos = json_decode(file_get_contents('php://input'),true);
            

            $atribute = ['name_subject'];
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
            
            $subject = new SubjectsModel(...$datos);
            if ($subject->save()) {
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
            echo  json_encode(['error' => $th->getMessage()]);
        }
    }


    /**
     *       funcion paara actualizar un registro 
    */
    public function updateSubject($id)
    {
        try {
            
            $datos = json_decode(file_get_contents('php://input'),true);

            $oldSubject = SubjectsModel::Find($id);
            if (isset($oldSubject)) {
                $oldSubject->name_subject = $datos['name_subject'];
                if ($oldSubject->update()) {
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
            echo  json_encode(['error' => $th->getMessage()]);
        }
    } 



    /**
     *      function  para eliminar un registro 
    */
    public function deleteSubject($id)
    {
        try {
            $existingSubject = SubjectsModel::Find($id);
            if (isset($existingSubject)) {
                if ($existingSubject->delete()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $existingSubject->toString() 
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
            echo json_encode(['error' =>$th->getMessage()]);
        }
    }





}
?>