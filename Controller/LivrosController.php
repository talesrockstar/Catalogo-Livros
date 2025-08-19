<?php
namespace Controller;

use Model\Livros;

require_once __DIR__ . '/../Config/configuration.php';

class LivrosController
{
    private function sanitizeArray($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->sanitizeArray($value);
            } else {
                $array[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $array;
    }

    public function getLivros()
    {
        $id = $_GET['id'] ?? null;
        $autor = $_GET['autor'] ?? null;
        $genero = $_GET['genero'] ?? null;
        $livro = new Livros();

        if ($id) {
            $result = $livro->getLivroById($id);
            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($this->sanitizeArray($result));
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Livro não encontrado"]);
            }
        } elseif ($autor) {
            $result = $livro->getLivrosByAutor($autor);
            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($this->sanitizeArray($result));
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Nenhum livro encontrado para esse autor"]);
            }
        } elseif ($genero) {
            $result = $livro->getLivrosByGenero($genero);
            if ($result) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($this->sanitizeArray($result));
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Nenhum livro encontrado para esse gênero"]);
            }
        } else {
            $livros = $livro->getLivros();
            if ($livros) {
                header('Content-Type: application/json', true, 200);
                echo json_encode($this->sanitizeArray($livros));
            } else {
                header('Content-Type: application/json', true, 404);
                echo json_encode(["message" => "Livros não encontrados"]);
            }
        }
    }

    public function createLivros()
    {
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

    public function updateLivros()
    {
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

    public function deleteLivros()
    {
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