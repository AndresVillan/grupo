<?php

class Conf
{
private $userdb;
private $passdb;
private $hostdb;
private $db;
 
static $_instance;
 
private function __construct(){
$this->userdb="root";
$this->passdb="";
$this->hostdb="localhost";
$this->db="androideros";
}
 
private function __clone(){ }
 
public static function getInstance(){
if (!(self::$_instance instanceof self)){
self::$_instance=new self();
}
return self::$_instance;
}
 
public function getUserDB(){
return $this->userdb;
}
 
public function getHostDB(){
return $this->hostdb;
}
 
public function getPassDB(){
return $this->passdb;
}
 
public function getDB(){
return $this->db;
}
 
}
?>