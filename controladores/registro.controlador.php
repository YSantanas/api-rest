<?php


// Incluir el modelo cliente
require_once "modelos/cliente.modelos.php";

//creamos una clase

class ControladorRegistro
{

    public function crearRegistro($datos)
    {

        //validando los datos obtenidos
        echo "<pre>";
        print_r($datos);
        echo "<pre>";

        /*
==========================================================
====================== VALIDANDO NOMBRE ==================
==========================================================
*/

        if (isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])) {

            $json = array(
                "status" => 404,
                "detalle" => "ERROR en el nombre*"

            );
            echo json_encode($json, true);

            return;
        }

        /*
==========================================================
==================== VALIDANDO APELLIDO ==================
==========================================================
*/

        if (isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["apellido"])) {

            $json = array(
                "status" => 404,
                "detalle" => "ERROR en el APELLIDO*"

            );
            echo json_encode($json, true);

            return;
        }

        /*=============================================
		Validar email
		=============================================*/


        if (isset($datos["email"]) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos["email"])) {

            $json = array(


                "status" => 404,
                "detalle" => "error en el CORREO"

            );

            echo json_encode($json, true);

            return;
        }

        /*=============================================
		Validar email REPETIDOS
		=============================================*/

        $clientes = ModeloCliente::inicioModeloCliente("clientes"); //Se coloca el nombre del campo


        foreach ($clientes as $key => $value) {

            if ($value["email"] == $datos["email"]) {

                $json = array(

                    "status" => 404,
                    "detalle" => "Correo Repetido"
                );

                echo json_encode($json, true);

                return;
            }
        }


        /*=============================================
		Generar Credenciales
		=============================================*/
        $id_cliente = str_replace("$", "c", crypt($datos["nombre"] . $datos["apellido"] . $datos["email"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $llave_secreta_cliente = str_replace("$", "a", crypt($datos["email"] . $datos["apellido"] . $datos["nombre"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        //echo "<pre>"; print_r($llave_secreta_cliente); echo "<pre>";


        //Crea un arreglo
        $datos = array(
            "nombre" => $datos["nombre"],
            "apellido" => $datos["apellido"],
            "email" => $datos["email"],
            "id_cliente" => $id_cliente, // Usar la clave correcta
            "llave_secreta" => $llave_secreta_cliente, // Usar la clave correcta
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s')
        );
        

        //se debe enviar esta informacion al modelo de cliente.modelo.php
        $crearM = ModeloCliente::crearSecreto("clientes", $datos);
        // tabla CLIENTES, y un array $datos



        if ($crearM == "ok") {

            $json = array(

                "status" => 404,
                "detalle" => "se genero sus credenciales",
                "id_cliente" => $id_cliente,
                "llave_secreta" => $llave_secreta_cliente

            );

            echo json_encode($json, true);

            return;
        }
    }
}
?>