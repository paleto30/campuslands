<?php

namespace App\Models\Position;

use Config\Database\Conexion;
use Exception;
use PDO;

class PositionModel
{

    public function __construct(private $name_position, private $arl ,  private $id = null)
    {
        $this->name_position = $name_position;
        $this->arl = $arl;
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
            'name_position' => $this->name_position,
            'arl' => $this->arl
        ];
    }



    //      consultar en la tabla position todos los registros
    public static function get(){
        try {
            $db = new Conexion;
            $query = "SELECT * FROM position";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $positions = $stament->fetchAll(PDO::FETCH_ASSOC);
            $db->closed();
            return $positions;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    /* 
            funcion para buscar un registro por id
            de la tanbla position 
    */
    public static function Find($id)
    {
        try {
            $db = new Conexion;
            $query = "SELECT *  FROM position WHERE id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(PDO::FETCH_ASSOC);
            $db->closed();

            $position = new self($result['name_position'],$result['arl'],$result['id']);

            if ($position->id !== null) {
                return $position;
            }
            
            return null;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    
    /**
     *      funcion para guardar una nueva positon
    */
    public function save()
    {
        try {
            $db = new Conexion;

            $query = "INSERT INTO position (name_position, arl) VALUES ( ?, ?)";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_position, $this->arl]);
            $db->closed();
            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    
    
    /**
     *      Funcion apara actualizar un registro de
     *      la tabla position
    */
    public function update(){
        try {
            $db = new Conexion;
            $query = "UPDATE position SET name_position = ?, arl = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query); 
            $stament->execute([$this->name_position, $this->arl, $this->id]);
            $db->closed();
            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     *      funcion para eliminar un
     *      registor de la tabla position si existe
    */
    public function delete(){
        try {
            $db = new Conexion; 
            $query = "DELETE FROM position  where id = ?";
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