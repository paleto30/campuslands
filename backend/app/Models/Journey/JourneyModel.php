<?php
namespace  App\Models\Journey;

use Config\Database\Conexion;
use Exception;
use PDO;

class JourneyModel
{


    public function __construct(private $name_journey, private $check_in, private $check_out, private $id = null)
    {
        $this->name_journey = $name_journey;
        $this->check_in = $check_in;
        $this->check_out = $check_out;
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
            'name_journey' => $this->name_journey,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out
        ];
    }
  
    
    /**
     *          funcion get para todos los registros 
    */
    public static function get()
    {
        try {
            $db = new Conexion;
            $query = "select * from journey";
            $stament = $db->connect()->prepare($query);
            $stament->execute();
            $journeys = $stament->fetchAll(PDO::FETCH_ASSOC);
            $db->closed();
            return $journeys;
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
            $query = "select * from journey where id = ?";
            $stament = $db->connect()->prepare($query);
            $stament->execute([$id]);
            $result = $stament->fetch(PDO::FETCH_ASSOC);            
            $journey = new self($result['name_journey'],$result['check_in'], $result['check_out'], $result['id']);
            $db->closed();
            if ($journey->id !== null) {
                return $journey;
            }
            return null;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /* 
            funcion para insertar un registro 
    */
    public function save()
    {
        try {
            $db = new Conexion;
            $query = "insert into journey (name_journey, check_in, check_out) values ( ?, ?, ?)";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->name_journey,$this->check_in, $this->check_out]);
            $db->closed();
            if ($ok) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    /* 
            funcion para actualizar un registro 
    */
    public  function update()
    {
        try {
            $db = new Conexion;
            $query = "update journey set name_journey = ?, check_in = ?, check_out = ? where id = ?";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->name_journey, $this->check_in, $this->check_out, $this->id]);
            $db->closed();
            if ($ok) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /*
            funcion para actualizar un registro 
    */
    public function delete()
    {
        try {
            $db = new Conexion;
            $query = "delete from journey where id = ?";
            $stament = $db->connect()->prepare($query);
            $ok = $stament->execute([$this->id]);
            $db->closed();
            if ($ok) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }












}
?>