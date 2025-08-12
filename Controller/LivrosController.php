<?php
namespace Controller;

use Model\Livros;

require_once __DIR__ . '/../Config/configuration.php';

class LivrosController
{
    // Função para pegar todos os livros
    public function getLivros()
    {
        $livro = new Livros();
        $livros = $livro->getLivros();

        if ($livros) {
            // Envia a resposta JSON
            header('Content-Type: application/json', true, 200);
            echo json_encode($livros);
        } else {
            header('Content-Type: application/json', true, 404);
            echo json_encode(["message" => "Livros não encontrados"]);
        }
    }

    // Função para criar um livro
    public function createLivros()
    {
        // Obtém os dados da requisição
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->titulo) && isset($data->autor) && isset($data->genero)) {
            $livro = new Livros();
            $livro->titulo = $data->titulo;
            $livro->autor = $data->autor;
            $livro->genero = $data->genero;

            if ($livro->createLivros()) {
                header('Content-Type: application/json', true, 201);
                echo json_encode(["message" => "Livro criado com sucesso"]);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(["message" => "Falha ao criar livro"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Informação inválida"]);
        }
    }

    // Função para editar um livro
    public function updateLivros()
    {
        // Obtém os dados da requisição
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && isset($data->titulo) && isset($data->autor) && isset($data->genero)) {
            $livro = new Livros();
            $livro->id = $data->id;
            $livro->titulo = $data->titulo;
            $livro->autor = $data->autor;
            $livro->genero = $data->genero;

            if ($livro->updateLivros()) {
                header('Content-Type: application/json', true, 200);
                echo json_encode(["message" => "Livro atualizado com sucesso"]);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(["message" => "Falha ao atualizar livro"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "Informação inválida"]);
        }
    }

    // Função para excluir um livro
    public function deleteLivros()
    {
        // Obtém os dados da requisição
        $id = $_GET['id'] ?? null; // Verifica se o ID foi passado na URL

        if ($id) {
            $livro = new Livros();
            $livro->id = $id;

            if ($livro->deleteLivros()) {
                header('Content-Type: application/json', true, 200);
                echo json_encode(["message" => "Livro excluído com sucesso"]);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(["message" => "Falha ao excluir livro"]);
            }
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(["message" => "ID inválido"]);
        }
    }
}

?>