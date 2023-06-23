<?php

namespace App\Models\Areas;

use Config\Database\Conexion;
use Exception;

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



    public static function getAllAreas()
    {
        try {
            $db = new Conexion;

            $query = "SELECT * FROM areas";
            $stament = $db->connect()->prepare($query); 
            $stament->execute();
            

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}





?>