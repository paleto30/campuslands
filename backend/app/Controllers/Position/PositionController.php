<?php 


namespace App\Controllers\Position;

use App\Models\Position\PositionModel;

class PositionController
{

   
    
    
    /**
     *      funcion para retornar todos los registros
     *      disponibles de la tabla  position
    */
    public function getAllPositions()
    {
        try {
            $positions = PositionModel::get();
            echo json_encode([
                'data' => $positions
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    
    /**
     *      funcion para insertar un registro de la 
     *      tabla position 
    */ 
    public function insertPosition()
    {
        try {
            
            $datos_position = json_decode(file_get_contents('php://input'),true);

            $atribute = ['name_position','arl']; // atributos de la tabla 
            $isValid = true;
            // validamos que los atributos sean los esperados y los valores no esten vacios
            foreach ($atribute as $key ) {
                if (!isset($datos_position[$key]) || empty(trim($datos_position[$key]))) {
                    $isValid = false;
                    http_response_code(400);
                    echo  json_encode([
                        'error-message' => "Atributos incorrecto o Valores vacios"
                    ]);
                    return;
                }
            }
            
            // varificamos que no existan atributos ni valores , no requeridos
            $extraKay = array_diff(array_keys($datos_position), $atribute);
            if (!empty($extraKay)) {
                $isValid = false;
                http_response_code(400);
                echo  json_encode([
                    'error-message' => "Atributos que no corresponden al modelo"
                ]);
                return;
            }

            // si  es verdadero entonces procedemos a crear el registro -> (creacion del registro)
            if ($isValid) {

                $position = new PositionModel(...$datos_position);
                if ($position->save()) {
                    http_response_code(201);
                    echo json_encode(['message'=> 'creado correctamente']);
                    return;
                }
                http_response_code(400);
                echo json_encode([
                    'error-message' => 'NO se a creado el registro'
                ]);
                return;
            }
        } catch (\Throwable $th) {
            echo json_encode(['error' =>$th->getMessage()]);
        }
    }



    /**
     *      funcion para actualizar un registro de la tabla 
     *      position.  El registro debe existir  
    */
    public function updatePositon($id)
    {
        try {

            $datos = $_POST;        
            $oldPosition = PositionModel::Find($id);

            if (isset($oldPosition)) {

                $oldPosition->name_position = $datos['name_position'];
                $oldPosition->arl = $datos['arl'];
                
                if ($oldPosition->update()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'Actualizado correctamente'
                    ]);
                    return;
                }else{
                    http_response_code(304);
                    echo json_encode([
                        'message' => 'Actualizado correctamente'
                    ]);
                    return;
                }
            }
            
            http_response_code(404);
            echo json_encode([
                'error-message' => 'El registro no existe'
            ]);
            return;
        } catch (\Throwable $th) {
            echo json_encode(['error' =>$th->getMessage()]);
        }
    }





    /**
     *      funcion para eliminar un registro de
     *      la tabla position
    */
    public function deletePosition($id){
        try {
            
            $existingPosition = PositionModel::Find($id);

            if (isset($existingPosition)) {
                if ($existingPosition->delete()) {
                    http_response_code(200);
                    echo json_encode([
                        'message' => 'eliminado correctamente',
                        'data' => $existingPosition->toString() 
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
            echo json_encode(['error' =>$th->getMessage()]);
        }
    }





























}

?>