<?php
include_once("User.php");
class Login{
    private $email;
    private $password;
    private $errorMessage = [];

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function setLogin(){
        $user = new User();
        $userData = $user->select($this->email);
        if ($userData) {   
            if (password_verify($this->password, $userData['password']) && $userData['status'] === 1) {
                $_SESSION["logged"] = true;
                header("Location: ../../pages/QuantityCalculator/index.php");
                die();
              }else {
                if (!password_verify($this->password, $userData['password'])) {
                    $this->errorMessage[] = "Invalid email or password";
                    return true;
                }else {
                    $this->errorMessage[] = "Account is not active";
                    return true;
                }
            }}else {
                $this->errorMessage[] = "Invalid email or password";
                return true;
        }
    }

    public function getErrors(): array {
        return $this->errorMessage;
    }
}
?>