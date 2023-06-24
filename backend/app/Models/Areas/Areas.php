<?php

namespace App\Models\Areas;

use Config\Database\Conexion;
use Exception;
use PDO;

class  Areas
{

    public function __construct(private $name_area)
    {
        $this->name_area = $name_area;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
                $this->$name = $value;
        }
        throw new Exception("Propiedad invalida: " . $name);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new Exception("Propiedad invalida: " . $name);
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
            $area = $stament->fetch(PDO::FETCH_ASSOC);  
            return $area;
        } catch (\Exception $e) {
            return  $e;
        }
    }  



    


}





?>