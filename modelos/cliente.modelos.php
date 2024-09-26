<?php


require_once "conexion.php";

class ModeloCliente
{



    

    //Mostrar todos los registros

    static public function inicioModeloCliente($tablaRegistro)
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaRegistro");
        $stmt->execute();

        //devolver toda la informacion de la bd
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    //Metodo que recibe del registro.controlador los datos de la llave

    static public function crearSecreto($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, email, id_cliente, llave_secreta, created_at, updated_at) VALUES (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :updated_at)");

        //
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":llave_secreta", $datos["llave_secreta"], PDO::PARAM_STR);
        $stmt->bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        //SI NO SE EJECUTA QUE DEVUELVA UN OK
        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt->close();

        $stmt = null;
    }
}
?>