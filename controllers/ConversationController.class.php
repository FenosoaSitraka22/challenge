<?php
require_once 'models/MessageService.php';
require_once 'models/ConversationService.class.php';
require_once 'models/Message.class.php';
class ConversationController
{
    private $messageService;
    private $conversationService;
    private $userService;

    function __construct()
    {
        $this->messageService = new MessageService();
        $this->conversationService = new ConversationService();
        $this->userService = new UserService();
    }

    function getConversation()
    {
        $idUser = $_SESSION['user']->getIdUser();
       if(isset($_GET['motCle'])){
        $conversation = $this->conversationService->getUserConversationsByKeyWord($idUser,$_GET['motCle']);
       }else{
        $conversation= $this->conversationService->getUserConversationsByKeyWord($idUser);
       }
        
        echo json_encode($conversation);
    }
   /* function searchConversation(){
        $idUser = $_SESSION['user']->getIdUser();
        $conversation= $this->conversationService->getUserConversationsByKeyWord($idUser,$_GET['motCle']);
        echo json_encode($conversation);
    }*/
    function getConversationMessages(){
        $messages = $this->messageService->getMessagesByIdConversation($_GET['id']);
        echo json_encode($messages);
    }
    function sendMessage(){
        $idUser=$_SESSION['user']->getidUser();
        $this->messageService->insertMessage($_POST['content'],$idUser,$_POST['idInterlocuteur'],$_POST['idConversation']);
    }
    function newConverstion(){
        $idConversation = $this->conversationService->saveConversation($_POST['titre']);
        // echo $idConversation;
        $receiver = $this->userService->getUserByEmail($_POST['email']);
         //var_dump($_SESSION['user']->getIdUser());
        // die;
        $idUser = $_SESSION['user']->getIdUser();
        
         $this->messageService->insertMessage($_POST['content'],$idUser,$receiver->getIdUser(),$idConversation);
    }
}
