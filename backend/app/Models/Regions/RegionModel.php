<?php

namespace  App\Models\Regions;

use Config\Database\Conexion;
use Exception;

class RegionModel
{
    
    public function __construct(private $name_region, private $id_country, private $id = null)
    {
        $this->name_region = $name_region;
        $this->id_country = $id_country;
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
            'name_region' => $this->name_region,
            'id_country'=> $this->id_country,
        ];
    }



    /**
     *          funcion get para todos los registros disponibles de la tabla 
     */
    public static function get(){
        try {
            $db = new Conexion;
            $query = "select * from regions";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $regions = $stament->fetchAll(\PDO::FETCH_ASSOC);
            return $regions;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *          funcion para encontrar un registro por id
     *          de la tabla regions
    */
    public static function Find($id)
    {
        try {
            $db = new Conexion;
            $query = "select * from regions where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(\PDO::FETCH_ASSOC);            
            $region = new self($result['name_region'],$result['id_country'],$result['id']);
            $db->closed();
            if ($region->id !== null) {
                return $region;
            }
            return null;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    /**
     *      funcion para guardat un registro del modelo
    */
    public function save()
    {
        try {
            $db = new Conexion;
            $query = "INSERT INTO regions (name_region, id_country) VALUES ( ?, ? )";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->name_region, $this->id_country]);
            $db->closed();
            return $ok;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *      funcion para actualizar un registro del modelo
    */
    public function update()
    {
        try {
            $db = new Conexion;
            $query = "UPDATE regions SET name_region = ? ,id_country = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query); 
            $ok = $stament->execute([$this->name_region,$this->id_country,$this->id]);
            $db->closed();
            return $ok;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *      funcion para eliminar un registro del modelo 
    */
    public function delete()
    {
        try {
            $db = new Conexion; 
            $query = "DELETE FROM regions  where id = ?";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->id]);
            $db->closed();
            return $ok;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



}

?>