<?php

class DatabaseConnection
{
  private $host = 'db';
  private $dbname = 'arqmedes_alpha_test';
  private $username = 'arqmedes_alpha';
  private $password = '12345678';

  protected $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      error_log('Conexão com database com sucesso' . "\n\n", 3, __DIR__ . '/../../error_log.txt');
    } catch (PDOException $e) {
      error_log('Erro na conexão do database:' . $e->getMessage() . "\n\n", 3, '../error_log.txt');
      echo 'Erro na conexão: ' . $e->getMessage();
    }
  }

  public function getConnection()
  {
    return $this->conn;
  }
}
