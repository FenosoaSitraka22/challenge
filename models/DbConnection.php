<?php
    abstract class DBConnection{
        private static $pdo;

        private function getConnection(){
            try{
               self::$pdo = new PDO("mysql:host=localhost;dbname=chat","root","");
            }catch (PDOException $e){
                echo $e->getMessage();
                die();
            }
        }
        protected function getPdo(){
            if(self::$pdo===null){
                $this->getConnection();
            }
            return self::$pdo;
        }
    }
?>