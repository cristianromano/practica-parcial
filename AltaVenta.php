<?php


include_once "./clases/pizza.php";

$sabor = $_POST['sabor'];
// $precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$email = $_POST['email'];
// $fecha = $_POST['fecha'];
$imagen = $_FILES['archivo'];
$cantidad = $_POST['cantidad'];

// var_dump($imagen);
// if (isset($sabor) && isset($precio) & isset($tipo) & isset($cantidad)) {

   
    
// }

$nombre = explode('@',$email);

//date("Y-m-d")

$path = $imagen['name'];
$extension = pathinfo($path, PATHINFO_EXTENSION);

$nombrePizza = $tipo.'-'.$sabor.'-'.$nombre[0].'-'."2021-10-19".'.'.$extension;

$pizza = Pizza::crearPizzaAlta($email,$sabor,$tipo,$cantidad,$nombrePizza);

if ($pizza->VentaPizza()) {
    $pizza->GuardarImagen($imagen);
}