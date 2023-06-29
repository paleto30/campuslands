<?php

namespace App\Models\Countries;

use Config\Database\Conexion;
use Exception;
use PDO;

class CountriesModel
{

    public function __construct(private $name_country, private $id = null)
    {
        $this->name_country = $name_country;
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
            'name_country' => $this->name_country, 
        ];
    }


    //  retornar todos los registros
    public static function get()
    {
        try {
            $db = new Conexion;

            $query = "SELECT * FROM countries";
            $stament = $db->connect()->prepare($query); 
            $stament->execute();
            $countries = $stament->fetchAll(PDO::FETCH_ASSOC);
            return $countries;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
    // consultar en la tabla areas un registro por id
    public static function  Find($id)
    {
        try {
            $db = new Conexion;

            $query = "SELECT * from countries WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result =  $stament->fetch(PDO::FETCH_ASSOC);  
            $db->closed();

            $country = new self($result['name_country'],$result['id']);
            if ($country->id !== null) {
                return $country;
            }
            return null;

        } catch (\Exception $e) {
           
        }
    }


    //insertar un nuevo registro
    public function save(){
        try {
            $db = new Conexion;

            $query = "INSERT INTO countries (name_country) VALUES ( ? )";
            $stament  = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->name_country]);
            return $ok;

        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }


    // funcion para actualizar un registro 
    public function update(){
        try {
            $db = new Conexion;

            $query = "UPDATE countries SET name_country = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->name_country,$this->id]);
            $db->closed();
            return $ok;
            
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }



    // funcion para eliminar un registro si existe
    public function delete(){   
        try {
            $db = new Conexion;

            $query = "DELETE FROM countries WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->id]);
            $db->closed();
            return $ok;
        } catch (\Throwable $th) {
             return  $th->getMessage();
        }
    }

}

?>