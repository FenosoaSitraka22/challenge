<?php
        // pour être convertir en objet JSON
    class User implements JsonSerializable {
        private $idUser;
        private $name;
        private $email;
        private $pwd;
        private $img;
        function __construct($idUser,$name,$email,$pwd,$img)
        {
                $this->idUser=$idUser;
                $this->name=$name;
                $this->email=$email;
                $this->pwd=$pwd;
                $this->img=$img;
        }


        // ///ahafahana mconvertir objet misy attrs private ho json, mila m'implementer interface JsonSerializable
        public function jsonSerialize(): mixed
        {
                $vars = get_object_vars($this);
                return $vars;

        }

        /**
         * Get the value of idUser
         */
        public function getIdUser()
        {
                return $this->idUser;
        }

        /**
         * Set the value of idUser
         */
        public function setIdUser($idUser): self
        {
                $this->idUser = $idUser;

                return $this;
        }

        /**
         * Get the value of name
         */
        public function getName()
        {
                return $this->name;
        }

        /**
         * Set the value of name
         */
        public function setName($name): self
        {
                $this->name = $name;

                return $this;
        }

        /**
         * Get the value of email
         */
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         */
        public function setEmail($email): self
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of pwd
         */
        public function getPwd()
        {
                return $this->pwd;
        }

        /**
         * Set the value of pwd
         */
        public function setPwd($pwd): self
        {
                $this->pwd = $pwd;

                return $this;
        }

        /**
         * Get the value of img
         */
        public function getImg()
        {
                return $this->img;
        }

        /**
         * Set the value of img
         */
        public function setImg($img): self
        {
                $this->img = $img;

                return $this;
        }
    }