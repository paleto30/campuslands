<?php

namespace App\Models\Areas;

use Config\Database\Conexion;
use Exception;
use PDO;

class  Areas
{

    public function __construct(private $name_area, private $id = null)
    {
        $this->name_area = $name_area;
        $this->id = $id;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
                $this->$name = $value;
        }else{
            throw new Exception("Propiedad invalida: " . $name);
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }else{
            throw new Exception("Propiedad invalida: " . $name);
        }
    }


    public function toString()
    {
        return [
            'id' => $this->id,
            'name_area' => $this->name_area, 
        ];
    }


    //  consultar en la tabala areas todos los registros
    public static function getAllAreas()
    {
        try {
            $db = new Conexion;

            $query = "SELECT * FROM areas";
            $stament = $db->connect()->prepare($query); 
            $stament->execute();
            $areas = $stament->fetchAll(PDO::FETCH_ASSOC);
            
            return $areas;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
    // consultar en la tabla areas un registro por id
    public static function  Find($id)
    {
        try {
            $db = new Conexion;

            $query = "SELECT * from areas WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result =  $stament->fetch(PDO::FETCH_ASSOC);  
            $db->closed();

            $area = new self($result['name_area'],$result['id']);
            
            if ($area->id !== null) {
                return $area;
            }
            return null;

        } catch (\Exception $e) {
           
        }
    } 




    //insertar una nueva Area
    public function save(){
        try {
            $db = new Conexion;

            $query = "INSERT INTO areas (name_area) VALUES ( ? )";
            $stament  = $db->connect()->prepare($query);
            $stament->execute([$this->name_area]);
            
            return true;

        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }


    // funcion para actualizar un registro de areas
    public function update(){
        try {
            $db = new Conexion;

            $query = "UPDATE areas SET name_area = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_area,$this->id]);
            $db->closed();
            return true;
            
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }



    // funcion para eliminar un registro si existe
    public function delete(){   
        try {
            $db = new Conexion;

            $query = "DELETE FROM areas WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->id]);
            $db->closed();
            return true;
        } catch (\Throwable $th) {
             return  $th->getMessage();
        }
    }
    


}





?>