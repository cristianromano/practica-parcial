<?php

$opcion = $_GET['opcion'];
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        switch ($opcion) {
            case 'PizzaCarga.php':
                include_once 'PizzaCarga.php';
                break;

            default:
                echo 'err';
                break;
        }
        break;
    case 'POST':
        switch ($opcion) {
            case 'PizzaCarga2.php':
                include_once 'PizzaCarga2.php';
                break;
            case 'AltaVenta.php':
                include_once 'AltaVenta.php';
                break;
            case 'PizzaConsultar.php':
                include_once 'PizzaConsultar.php';
                break;
            default:
                echo 'err';
                break;
        }
        break;
    case 'PUT':
        switch ($opcion) {
            case 'ModificarVenta.php':
                include_once 'ModificarVenta.php';
                break;

            default:
                echo 'err';
                break;
        }
        break;
    case 'DELETE':
        switch ($opcion) {
            case 'borrarVenta.php':
                include_once 'borrarVenta.php';
                break;

            default:
                echo 'err';
                break;
        }
        break;
    default:
        echo 'err';
        break;
}
