<?php


//se requiere el controlador


require_once "controladores/rutas.controlador.php";
require_once "controladores/cursos.controlador.php";
require_once "controladores/registro.controlador.php";

//Se requieren los modelos creados
require_once "modelos/cursos.modelos.php";
//require_once "modelos/clientes.modelos.php";

//objeto donde se llama a la clase de rutas

//Se utiliza la clase de rutas.controlador
$rutas = new ControladorRutas();
//Se llama al metodo inicio
$rutas->inicio();
?>