<?php


class Users extends Controller {
    public function __construct() {
    $this->userModel = $this->model('User');
    }

    public function register() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error'
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email is already taken';
                }
            }

            // Validate Name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter name';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be at least six characters';
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please enter confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = 'Confirm password must match password';
                }
            }

            // Make sure errors are empty
            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error'])
                && empty($data['confirm_password_error'])) {
                // Validated

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error'
            ];

            // Load view
            $this->view('users/register', $data);
        }
    }

    public function login() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter email';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            }

            // Make sure errors are empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // Validated
                if ($user = $this->userModel->login($data['email'], $data['password'])) {
                    // Logged in
                    $this->createUserSession($user);
                } else {
                    $data['email_error'] = 'Invalid credentials';
                    $data['password_error'] = 'Invalid credentials';

                    // Load view with errors
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => ''
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;

        redirect('posts');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }
}