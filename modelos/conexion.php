<?php

class Conexion
{
    static public function conectar()
    {
        //PDO es una clase de PHP que se usa para las BD
        $link = new PDO("mysql:host=localhost;port=3307;dbname=api-rest", "root", "");
        //api-rest es el nombre de la base de datos, se pone el user y el pass


        $link->exec("set names utf8");

        return $link;
    }
}

?>