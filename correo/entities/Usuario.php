<?php

class Usuario 
{
    // Properties
    private $nombre;
    private $email;
    private $jamon;


    // Constructor
    public function __construct($nombre = null, $email = null, $jamon = null) {
        $this->setNombre($nombre);
        $this->setEmail($email);
        $this->setJamon($jamon);
    }


    // Getters and Setters
    public function getNombre()
    {
        return $this->nombre;
    }
    private function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }
    private function setEmail($email)
    {
        $this->email = $email;
    }

    public function getJamon()
    {
        return $this->jamon;
    }
    private function setJamon($jamon)
    {
        $this->jamon = $jamon;
    }
}

?>
