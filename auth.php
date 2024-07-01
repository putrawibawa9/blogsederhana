<?php
require_once "connect.php";
session_start();

class Auth extends Connect{
    public $error =false;
    public $row;

public function register($data){
   $conn = $this->getConnection();
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO admin VALUES 
        (null,?,?)";
    
        $stmt = $conn->prepare($query);
    
        $stmt->bindParam(1,$username);
        $stmt->bindParam(2,$password);
        $stmt->execute();
        return true;
}
    
public function login ($username, $password){

    $connection = $this->getConnection();
    $query = "SELECT password FROM admin WHERE username = ?";
    $result = $connection->prepare($query);
    $result->execute([$username]);
    $passDB = $result->fetch();
    $passwordVerify = password_verify($password, $passDB['password']);

    // $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    // $result = $connection->prepare($query);
    // $result->execute([$username, $passwordVerify]);
    if($passwordVerify){
        $_SESSION['nama_admin'] = $username;  
        header("Location: blog/");
    }else{
        $this->error = True;
        header("Location: index.php?error=1");
        exit();
    };
   
    }

public function logout(){
    session_destroy();
    header("Location: index.php");
    exit;
}
}
?>