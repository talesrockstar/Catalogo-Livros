<?php
require_once __DIR__ . '/vendor/autoload.php';

use Controller\LivrosController;
$livrosController = new LivrosController();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $livrosController->getLivros();
        break;
    case 'POST':
        $livrosController->createLivros();
        break;
    case 'PUT':
        $livrosController->updateLivros();
        break;
    case 'DELETE':
        $livrosController->deleteLivros();
        break;
    default:
        echo json_encode(["message" => "Método não permitido"]);
        break;
}
?>