<?php
require_once 'models/UserService.class.php';
class UserController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    function authentification()
    {
        $userEmail = $_POST['email'];
       // $userPwd = crypt($_POST['pwd'], "salt");
       $userPwd = $_POST['pwd'];
        $user = $this->userService->getUserByEmailAndPwd($userEmail, $userPwd);
        $data = ['user'=>$user];
        if($user){
            //session_start();
            $_SESSION['user'] =$user;
            $data['error']= false;
        }else{
            $data['error'] = true;
        }
       // header('Content-Type : application/json');
        echo json_encode($data);
    }
    function signInRequest()
    {
        $user = new User(
            null,
            $_POST['name'],
            $_POST['email'],
            $_POST['pwd'],
            $_POST['img']
        );
       $user = $this->userService->insertUser($user);
       $_SESSION['user'] =$user;
       echo json_encode($user);
    }
    function getUser(){
       echo json_encode( $this->userService->getUserById(2));
    }

    function testConnection(){
        if(isset($_SESSION['user'])){
            $data = ['isConnected'=>true];
        }else{
            $data = ['isConnected'=>false];
        }
        echo json_encode($data);
    }
    function logout(){
        session_destroy();
    }
    
}
