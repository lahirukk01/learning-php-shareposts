<?php

class Post {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function addPost($data) {
        $this->db->query('INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($id) {
        $this->db->query("SELECT posts.id as post_id, users.id as user_id, posts.created_at as post_created_at, title, body, name, email
                                FROM posts 
                                INNER JOIN users ON posts.user_id = users.id 
                                WHERE posts.id = :id ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPosts() {
        $this->db->query("SELECT *, posts.id as post_id, users.id as user_id, posts.created_at as post_created_at FROM posts 
                                INNER JOIN users ON posts.user_id = users.id 
                                ORDER BY posts.created_at DESC ");
        return $this->db->resultSet();
    }

    public function updatePost($data) {
        $this->db->query("UPDATE posts SET title = :title, body = :body WHERE id = :id");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':id', $data['id']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($id) {
        $this->db->query("DELETE FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}