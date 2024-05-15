<?php
require_once 'models/DbConnection.php';
require_once 'models/Message.class.php';
class MessageService extends DBConnection
{
    function getMessagesByIdConversation($idConversation)
    {
        $req = $this->getPdo()->prepare('SELECT * FROM message WHERE idConversation=?');
        $req->execute([$idConversation]);
        $listMessages = $req->fetchAll(PDO::FETCH_ASSOC);
        $ObjectMessages = [];
        foreach ($listMessages as $message) {
            $ObjectMessages[] = new Message($message['idMessage'], $message['contenu'], $message['idSender'], $message['idReceiver'], $message['dateCreation']);
        }
        return $ObjectMessages;
    }
   /// saveMessage($_POST['content'],$idUser,$receiver->getIdUser(),$idConversation)
    function insertMessage($content,$idSender,$idReceiver,$idConversation){
        $req = $this->getPdo()->prepare('INSERT INTO message (contenu,idSender,idReceiver,idConversation) VALUES (?,?,?,?)');
        $req->execute([$content,$idSender,$idReceiver,$idConversation]);
    }
};
