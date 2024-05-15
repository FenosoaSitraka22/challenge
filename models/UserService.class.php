<?php
require_once 'models/DbConnection.php';
require_once 'models/User.class.php';
class UserService extends DbConnection
{

    function getUserByEmailAndPwd($email, $pwd)
    {
        $req = $this->getPdo()->prepare('SELECT * FROM user WHERE email=? AND pwd= ?');
        $req->execute([$email, $pwd]);
        $userFromBase = $req->fetch();
        if ($userFromBase) {
            return new User(
                $userFromBase['idUser'],
                $userFromBase['name'],
                $userFromBase['email'],
                $userFromBase['pwd'],
                $userFromBase['img'],
            );
        } else {
            return false;
        }
    }
    function getUserById($id)
    {
        $req = $this->getPdo()->prepare('SELECT * FROM user WHERE idUser=?');
        $req->execute([$id]);
        $userFromBase = $req->fetch();
        
        return new User(
                $userFromBase['idUser'],
                $userFromBase['name'],
                $userFromBase['email'],
                $userFromBase['pwd'],
                $userFromBase['img'],
        );
    }
    function getUserByEmail($email){
        $req = $this->getPdo()->prepare('SELECT * FROM user WHERE email = ?');
        $req->execute([$email]);
        $res = $req->fetch();
        if($res){
            return new User(
                $res['idUser'],
                $res['name'],
                $res['email'],
                $res['pwd'],
                $res['img'],
            );
        }else{
            return ['error'=>'utilisateur introuvable'];
        }
    }

    function insertUser($user)
    {
       $req = $this->getPdo()->prepare('INSERT INTO user (name,email,pwd,img)VALUES(?,?,?,?)');
        $req->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPwd(),
            $user->getImg(),
        ]);
        $user->setIdUser($this->getPdo()->lastInsertId());
        return $user;
    }
}
