<?php
include_once("..\admin\database\conn.php");
class Validation{
    private $name; 
    private $value;
    private $errors = [];

    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }
    public function required():bool{
        if (empty($this->value) || trim($this->value) === "") {
            $this->errors[] = "The {$this->name} field is required.";
            return false;
        }
        return true;
    }
    public function regex($pattern):bool{
        if (!preg_match($pattern, $this->value)) {
            $this->errors[] = "The {$this->name} format is invalid.";
            return false;
        }
        return true;
    }
    public function unique($table):bool{ 
        $query= "SELECT * FROM $table WHERE $this->name=? "; 
        $conn=new Conn;
        $result=$conn->runDQL($query,$this->value);
        // echo $result;
        if(empty( $result)){
            return true;
        }
        $this->errors[] = "The {$this->name} is already exists";
        return false;
    }
    public function hasErrors(): bool {
        return !empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
?>