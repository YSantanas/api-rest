<?php

// SE DETECTA TODA LA URL
$arregloRuta = explode("/", $_SERVER['REQUEST_URI']);


echo "<pre>";
print_r($arregloRuta);
echo "<pre>";


if(isset($_GET["pagina"]) && is_numeric($_GET["pagina"])){

    $cursos=new ControladorCursos();
    $cursos->inicioCursos($_GET["pagina"]);



}else{


//Si el indice es 2 es decir igual a api-rest entonces marca detalle 
//no encontrado también en caso contrario no muestra esa última condición.

//================================================================
//================== Cuando NO se pasa un Indice ====================
//================================================================
// NO HAY PETICIONES A LA API

if (count(array_filter($arregloRuta)) == 2) {

    // se encarga de mostrar cuando no existe alguna ruta
    $json = array(
        "detalle" => "no encontrado"

    );
    echo json_encode($json, true);
} else {

    //================================================================
    //================== Cuando se pasa un Indice ====================
    //================================================================
    // por tanto hay una petición a la API

    //Si estamos en el indice 3 es decir /api-rest/CURSOS, cursos o lo que sea que tengamos

    if (count(array_filter($arregloRuta)) == 3) {

        if (array_filter($arregloRuta)[3] == "cursos") {
            //si la direccion del arreglo se encuentra en el indice 3 y además es = a cursos entonces


            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
                //Si existe un metodo  y si ese metodo es = POST


                /*=============================================
					Capturar datos
					=============================================*/

                $datos = array(
                    "titulo" => $_POST["titulo"],
                    "descripcion" => $_POST["descripcion"],
                    "instructor" => $_POST["instructor"],
                    "imagen" => $_POST["imagen"],
                    "precio" => $_POST["precio"]
                );

                //  echo "<pre>"; print_r($datos); echo "<pre>";

                $cursos = new ControladorCursos();
                $cursos->crearCursos($datos);
            } else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {
                $cursos = new ControladorCursos();
                $cursos->inicioCursos(null);
            }
        }


        if (array_filter($arregloRuta)[3] == "registro") {
            //si la direccion del arreglo se encuentra en el indice 3 y además es = a cursos entonces
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {

                //cachamos los parametros de la bd

                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "apellido" => $_POST["apellido"],
                    "email" => $_POST["email"]
                );

                //imprimir los datos
                //echo "<pre>"; print_r($datos);  echo "<pre>";
                //Si existe un metodo  y si ese metodo es = POST
                $registro = new ControladorRegistro();
                $registro->crearRegistro($datos);
            }
        }
    }
    //caso contrario del if general
    else {

        if (array_filter($arregloRuta)[3] == "cursos" && is_numeric(array_filter($arregloRuta)[4])) {

            /*=============================================
            Peticiones GET
            =============================================*/

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET") {

                $curso = new ControladorCursos();
                $curso->show(array_filter($arregloRuta)[4]);
            }

            /*=============================================
            Peticiones put
            =============================================*/

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT") {

                /*=============================================
                Capturar datos
                =============================================*/

                $datos = array();

                parse_str(file_get_contents('php://input'), $datos);

                //echo "<pre>"; print_r($datos); echo "<pre>";

                //return;





                $editarCurso = new ControladorCursos();
                $editarCurso->update(array_filter($arregloRuta)[4], $datos);
            }



            /*=============================================
            Peticiones DELETE
            =============================================*/

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE") {

                $borrarCurso = new ControladorCursos();
                $borrarCurso->delete(array_filter($arregloRuta)[4]);
            }
        }
    }
}
}
?>