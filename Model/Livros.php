<?php
namespace Model;

use PDO;
use Model\Connection;

class Livros
{
    private $conn;

    public $id;
    public $titulo;
    public $autor;
    public $genero;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }

    public function getLivros()
    {
        $sql = "SELECT * FROM livros";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLivroById($id)
    {
        $sql = "SELECT * FROM livros WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createLivros()
    {
        $sql = "INSERT INTO livros (titulo, autor, genero) VALUES (:titulo, :autor, :genero)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
        $stmt->bindParam(":autor", $this->autor, PDO::PARAM_STR);
        $stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateLivros()
    {
        $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
        $stmt->bindParam(":autor", $this->autor, PDO::PARAM_STR);
        $stmt->bindParam(":genero", $this->genero, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteLivros()
    {
        $sql = "DELETE FROM livros WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getLivrosByAutor($autor)
    {
        $sql = "SELECT * FROM livros WHERE autor = :autor";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":autor", $autor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLivrosByGenero($genero)
    {
        $sql = "SELECT * FROM livros WHERE genero = :genero";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":genero", $genero, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>