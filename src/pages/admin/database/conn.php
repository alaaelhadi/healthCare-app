<?php
class Conn{
   private $servername = "localhost";
   private $username = "root";
   private $password = "";
   private $dbname = "healthcare";
   private $conn ;
   public function __construct(){
      try {
      $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "connected";
      }catch(PDOException $e) {
         echo "Connection failed: " . $e->getMessage();
      }
   }

   public function runDML(string $query, array $data) : bool{
      $stmt = $this->conn->prepare($query);
      $result=$stmt->execute($data);
      if($result){
         return true;
      }
      return false;
   }

   public function runDQL(string $query,$value){
      $stmt=$this->conn->prepare($query);
      $stmt->execute([$value]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ?: [];
      // $result=$stmt->rowCount();
      // if( $result > 0){
      //    return $result ;
      // }
      // return [];
   }

}
// $x= new config();
?>