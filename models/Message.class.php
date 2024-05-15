<?php
class Message implements JsonSerializable
{
    private $idMessage;
    private $content;
    private $idSender;
    private $idReceiver;
    private $createdAt;

    function __construct($idMessage, $c, $idSender, $idReceiver, $createdAt)
    {
        $this->idMessage = $idMessage;
        $this->content = $c;
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
        $this->createdAt = $createdAt;
    }

    function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;
    }
    function getMessage()
    {
        return $this->idMessage;
    }
    function setContent($content)
    {
        $this->content = $content;
    }
    function setIdSender($idSender)
    {
        $this->idSender = $idSender;
    }
    function setIdReceiver($idreceiver)
    {
        $this->idReceiver = $idreceiver;
    }
    function setcreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    function getContent()
    {
        return $this->content;
    }
    function getIdSender()
    {
        return $this->idSender;
    }
    function getIdReceiver()
    {
        return $this->idReceiver;
    }
    function getcreatedAt()
    {
        return  $this->createdAt;
    }

    function jsonSerialize(): mixed
    {
        $vars = get_object_vars($this);
        return $vars;
    }
};
