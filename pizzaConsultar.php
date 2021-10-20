<?php

include_once "./clases/pizza.php";

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
// $opcion = $_POST['opcion'];


if (isset($sabor) && isset($precio) & isset($tipo) & isset($cantidad)) {

    $pizza = new Pizza($sabor, $precio, $tipo, $cantidad, 0);

    $rta = Pizza::VerificoPizza($pizza);
    if ($rta) {
        echo "</br>" . "hay pizza" . "<br>";
    } else {
        echo ',no hay pizza de ese estilo'.'</br>';
    }
}
