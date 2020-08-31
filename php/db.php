<?php

class DBConnection
{
  // Default Connection parameters
  private $DB_HOST = 'localhost';
  private $DB_PORT = '3306';
  private $DB_USERNAME = 'app';
  private $DB_PASSWORD = 'app';
  private $DB_NAME = 'app';

  // PDO Options
  private $options = [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
  ];

  public function __construct()
  {

    $this->DB_HOST = $_ENV['DB_HOST'] ?? $this->DB_HOST;
    $this->DB_PORT = $_ENV['DB_PORT'] ?? $this->DB_PORT;
    $this->DB_USERNAME = $_ENV['DB_USERNAME'] ?? $this->DB_USERNAME;
    $this->DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? $this->DB_PASSWORD;
    $this->DB_NAME = $_ENV['DB_NAME'] ?? $this->DB_NAME;

    $this->dsn = "mysql:host={$this->DB_HOST};port={$this->DB_PORT};dbname={$this->DB_NAME};charset=utf8mb4";
  }

  public function connect()
  {
    try {
      return new PDO($this->dsn, $this->DB_USERNAME, $this->DB_PASSWORD, $this->options);
    } catch (Exception $e) {
      error_log($e->getMessage());
      exit('Connection failed');
    }
  }
}
