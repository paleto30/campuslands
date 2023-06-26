<?php

namespace App\Models\Subjects;

use Config\Database\Conexion;
use Exception;
use PDO;

class SubjectsModel
{


    public function __construct(private $name_subject, private $id = null)
    {
        $this->name_subject = $name_subject;
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
            'name_subject' => $this->name_subject
        ];
    }



    /**
     *          funcion get para todos los registros disponibles de la tabla 
     */
    public static function get(){
        try {
            $db = new Conexion;
            $query = "select * from subjects";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $subjects = $stament->fetchAll(PDO::FETCH_ASSOC);
            return $subjects;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *          funcion para encontrar un registro por id
     *          de la tabla subjects
    */
    public static function Find($id)
    {
        try {
            $db = new Conexion;
            $query = "select * from subjects where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(PDO::FETCH_ASSOC);            
            $subject = new self($result['name_subject'],$result['id']);
            $db->closed();
            if ($subject->id !== null) {
                return $subject;
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
            $query = "INSERT INTO subjects (name_subject) VALUES ( ? )";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$this->name_subject]);
            $db->closed();
            return true;
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
            $query = "UPDATE subjects SET name_subject = ? WHERE id = ?";
            $stament = $db->connect()->prepare($query); 
            $stament->execute([$this->name_subject,$this->id]);
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
            $query = "DELETE FROM subjects  where id = ?";
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
