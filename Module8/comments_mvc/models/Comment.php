<?php
class Comment {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "test");
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM comments");
    }

    public function insert($comment) {
        $stmt = $this->conn->prepare("INSERT INTO comments (comment) VALUES (?)");
        $stmt->bind_param("s", $comment);
        $stmt->execute();
    }

    public function update($id, $comment) {
        $stmt = $this->conn->prepare("UPDATE comments SET comment=? WHERE id=?");
        $stmt->bind_param("si", $comment, $id);
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
