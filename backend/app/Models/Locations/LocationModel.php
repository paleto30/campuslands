<?php

namespace App\Models\Locations;

use Config\Database\Conexion;
use Exception;
use PDO;

class LocationModel
{

    public function __construct(private $name_location,  private $id = null)
    {
        $this->name_location = $name_location;
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
            'name_location' => $this->name_location,
        ];
    }
  
    
    /**
     *          funcion get para todos los registros 
    */
    public static function get()
    {
        try {
            $db = new Conexion;
            $query = "select * from locations";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $locations = $stament->fetchAll(PDO::FETCH_ASSOC);
            $db->closed();
            return $locations;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *      funcion para obtene run registro por id
    */
    public static function Find($id)
    {
        try {
            $db = new Conexion;
            $query = "Select * from locations where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(PDO::FETCH_ASSOC);
            $db->closed();
            
            $location = new self($result['name_location'],$result['id']);
            if ($location->id !== null) {
                return $location;
            }
            return null;
        } catch (\Exception $e) {
            return $e->getMessage();
        }   
    }


    /**
     *      funcion para guardar un registro del modelo 
    */
    public function save()
    {
        try {
            $db = new Conexion;
            $query = "insert into locations (name_location) values ( ?)";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_location]);
            $db->closed();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    /**
     *      funcion para actualizar un registro 
    */
    public function update()
    {
        try {
            $db = new Conexion;
            $query = "update locations set name_location = ? where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_location,$this->id]);
            $db->closed();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *      funcion para borrar un registro
    */
    public function delete()
    {
        try {
            $db = new Conexion;
            $query = "delete from locations where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->id]);
            $db->closed();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }













}





?>