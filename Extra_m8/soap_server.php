<?php
class BookService {

    public function getBooks() {
        return [
            ["id" => 1, "title" => "PHP Basics", "author" => "John"],
            ["id" => 2, "title" => "Web Services", "author" => "Milan"]
        ];
    }

    public function addBook($title, $author) {
        return "Book added successfully";
    }

    public function updateBook($id, $title) {
        return "Book updated successfully";
    }

    public function deleteBook($id) {
        return "Book deleted successfully";
    }
}

$server = new SoapServer(null, ['uri' => "http://localhost/Extra_m8/soap"]);
$server->setClass('BookService');
$server->handle();
