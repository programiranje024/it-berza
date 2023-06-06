<?php

class Db {
  protected $DB_HOST = "mysql";
  protected $DB_NAME = "itberza";
  protected $DB_PASS = "itberza";
  protected $DB_USER = "itberza";
  protected $DB_INSTANCE = null;

  public function __construct() {
    $this->DB_INSTANCE = new PDO($this->constructConnectionString(), $this->DB_USER, $this->DB_PASS);
  }

  public function getInstance() {
    return $this->DB_INSTANCE;
  }

  private function constructConnectionString() {
    return "mysql:host=$this->DB_HOST;dbname=$this->DB_NAME;charset=utf8";
  }
}
