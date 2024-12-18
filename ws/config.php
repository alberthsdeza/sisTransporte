<?php
class Connect extends PDO {
    private $host = 'localhost';
    private $port = '5432';
    private $dbname = 'db_sisgdvt';
    private $user = 'postgres';
    private $password = 'alexis12';

    public function __construct() {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
        try {
            parent::__construct($dsn, $this->user, $this->password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            exit;
        }
    }
}