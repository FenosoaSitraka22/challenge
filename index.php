<?php

header('access-Control-Allow-Origin: *');
header('access-Control-Allow-Methods: POST, GET, PUT,OPTIONS,PATCH, DELETE');

require_once "controllers/UserController.class.php";
require_once "controllers/ConversationController.class.php";

$userController = new UserController();
$conversationController = new ConversationController();
session_start();
if (isset($_SESSION['user'])) {
   if($_GET['action']=='getConversation'){
        $conversationController->getConversation();
   }elseif($_GET['action']=='getMessages'){
        $conversationController->getConversationMessages();
   }elseif($_GET['action']=='isConnected'){
        $userController->testConnection();
   }elseif($_GET['action']=="sendmsg"){
    $conversationController->sendMessage();
   }elseif($_GET['action']=="newConversation"){
    $conversationController->newConverstion();
   } elseif($_GET['action']=='logout'){
    $userController->logout();
   }    
} elseif ($_GET['action'] == 'authentification') {
    $userController->authentification();
} elseif ($_GET['action'] == 'signIn') {
    $userController->signInRequest();
} elseif($_GET['action']=="getUser"){
    $userController->getUser();
}elseif($_GET['action']=='isConnected'){
    $userController->testConnection();
}
