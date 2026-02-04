<?php
require_once "models/Comment.php";

class CommentController {

    private $model;

    public function __construct() {
        $this->model = new Comment();
    }

    public function handleRequest() {

        if (isset($_POST['add'])) {
            $this->model->insert($_POST['comment']);
        }

        if (isset($_POST['update'])) {
            $this->model->update($_POST['id'], $_POST['comment']);
        }

        if (isset($_GET['delete'])) {
            $this->model->delete($_GET['delete']);
        }

        $comments = $this->model->getAll();
        require "views/comments.php";
    }
}
