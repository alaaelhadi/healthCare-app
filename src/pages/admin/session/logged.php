<?php
class SessionManager {
    public function __construct() {
        session_start(); // Start session automatically
    }
    
    // public function setLoggedIn(): void {
    //     $_SESSION["logged"] = true;
    // }

    // public function isLoggedIn(): bool {
    //     return isset($_SESSION["logged"]) && $_SESSION["logged"];
    // }

    // public function redirectToLandingPage(): void {
    //     if ($this->isLoggedIn()) {
    //         header("Location: ../../pages/QuantityCalculator/index.php");
    //         die();
    //     }else {
    //         header("Location: index.php"); // Redirect to index if not logged in
    //         die();
    //     }
    // }

    public function requireLogin(): void {  
        if(!isset($_SESSION["logged"]) or !$_SESSION["logged"]){
            header("Location: ../../pages/login&signup/index.php");
            die();
        }
    }

    public function logout(): void {
        // Destroy current session
        session_destroy();

        // Optionally, redirect to specific page after logout (replace with your desired page)
        header("Location: ../../pages/login&signup/index.php");
        die();
    }
}
?>