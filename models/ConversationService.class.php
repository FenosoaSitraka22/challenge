<?php
    require_once 'models/UserService.class.php';
    class ConversationService extends DBConnection{

        function getUserConversations($idUser){
            $req=$this->getPdo()->prepare("
                SELECT DISTINCT(conversation.idConversation), conversation.titre, 
                CASE 
                    WHEN message.idSender = ? THEN message.idReceiver
                    WHEN message.idReceiver = ? THEN message.idSender
                END AS idInterlocuteur
                FROM message
                INNER JOIN conversation ON conversation.idConversation = message.idConversation
                WHERE (message.idSender = ? OR message.idReceiver = ?)"
            );
            $req->execute([$idUser,$idUser,$idUser,$idUser]);
           $results =  $req->fetchAll(PDO::FETCH_ASSOC);
            if($results){
                $userService = new UserService();
                //recuperation de l'interlocuteur
                 $newResult = [];
                foreach($results as $r){
                     $r['interlocuteur'] = $userService->getUserById($r['idInterlocuteur']);
                     $newResult[] = $r;
                }
                //var_dump($results);
               return ['haveConversation'=>true,'conversations'=>$newResult];
            }else{
                return ['haveConversation'=>false];
            }
           

        }
        function getUserConversationsByKeyWord($idUser,$key=""){
            $query ="
            SELECT DISTINCT(conversation.idConversation), conversation.titre, 
            CASE 
                WHEN message.idSender = ".$idUser." THEN message.idReceiver
                WHEN message.idReceiver = ".$idUser." THEN message.idSender
            END AS idInterlocuteur
            FROM message
            INNER JOIN conversation ON conversation.idConversation = message.idConversation
            WHERE (message.idSender = ".$idUser." OR message.idReceiver = ".$idUser.") AND (conversation.titre LIKE '%".$key."%')";
       
            $req=$this->getPdo()->query($query);
            $req->execute();
           $results =  $req->fetchAll(PDO::FETCH_ASSOC);
            if($results){
                $userService = new UserService();
                //recuperation de l'interlocuteur
                 $newResult = [];
                foreach($results as $r){
                     $r['interlocuteur'] = $userService->getUserById($r['idInterlocuteur']);
                     $newResult[] = $r;
                }
                //var_dump($results);
               return ['haveConversation'=>true,'conversations'=>$newResult];
            }else{
                return ['haveConversation'=>false];
            }
           

        }

        function saveConversation($titre){
            $req = $this->getPdo()->prepare('INSERT INTO conversation (titre) VALUES (?)');
            $req->execute([$titre]);
            return $this->getPdo()->lastInsertId();
        }
    }