<?php
/*TODO: Inicializando la sesion del usuario */
session_start();
/*TODO: Iniciamos Clase Conectar */
class Conectar
{
    protected $dbh;

    //Funcion para conectarme con la base de datos, está en postgresql
    protected function conexion()
    {
        try {
            $conectar = $this->dbh = new PDO("pgsql:host=localhost;port=5432;dbname=dbsimcix", "postgres", "alexis12");
            return $conectar;
        } catch (Exception $e) {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    /*Funcion para que no tengamos problemas con las ñ o con las tildes
        en los registros de la base de datos estoy trabajando en postgresql*/
    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }
    /*TODO: Ruta principal del proyecto */
    public static function ruta()
    {
        //QA
        return "http://192.168.101.5/sisTransporte/";
    }
}
