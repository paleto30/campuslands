<?php

namespace App\Models\Levels;

use Config\Database\Conexion;
use Exception;
use PDO;

class LevelsModel
{


    public function __construct(private $name_level, private $group_level ,  private $id = null)
    {
        $this->name_level = $name_level;
        $this->group_level = $group_level;
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
            'name_level' => $this->name_level,
            'group_level' => $this->group_level
        ];
    }
  
    
    /**
     *          funcion get para todos los registros 
    */
    public static function get()
    {
        try {
            $db = new Conexion;
            $query = "select * from levels";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $levels = $stament->fetchAll(PDO::FETCH_ASSOC);
            $db->closed();
            return $levels;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /* 
                funcion para buscar un registro por id
    */
    public static function Find($id)
    {
        try {  
            $db = new Conexion;
            $query = "select * from levels where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(PDO::FETCH_ASSOC);            
            $level = new self($result['name_level'],$result['group_level'], $result['id']);
            $db->closed();
            if ($level->id !== null) {
                return $level;
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
            $query = "INSERT INTO levels (name_level, group_level ) VALUES ( ?, ?)";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_level, $this->group_level]);
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
            $query = "UPDATE levels SET name_level = ? , group_level = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query); 
            $stament->execute([$this->name_level, $this->group_level, $this->id]);
            $db->closed();
            return true;
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
            $query = "DELETE FROM levels  where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->id]);
            $db->closed();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
?>