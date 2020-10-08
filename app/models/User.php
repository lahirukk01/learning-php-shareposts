<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Register user
    public function register($data) {
        $this->db->query('INSERT INTO users (name, email, user_password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Log in user
    public function login($email, $password) {
        if ($user = $this->findUserByEmail($email)) {
            if (password_verify($password, $user->user_password)) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    // Find user by id
    public function findUserById($id) {
        $this->db->query('SELECT * FROM users WHERE email = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return null;
        }
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return null;
        }
    }
}
