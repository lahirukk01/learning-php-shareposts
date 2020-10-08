<?php


class Posts extends Controller {
    /**
     * @var mixed
     */
    private $postModel;

    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
    }

    public function index() {
        $data = [
            'posts' => $this->postModel->getPosts()
        ];
        $this->view('posts/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => trim($_SESSION['user_id']),
                'title_error' => '',
                'body_error' => ''
            ];

            // Validate data
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter body';
            }

            if (empty($data['title_error']) && empty($data['body_error'])) {
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }
    }

    public function show($id) {
        $data = [
            'post' => $this->postModel->getPostById($id)
        ];
        $this->view('posts/show', $data);
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => trim($_SESSION['user_id']),
                'title_error' => '',
                'body_error' => ''
            ];

            // Validate data
            if (empty($data['title'])) {
                $data['title_error'] = 'Please enter title';
            }

            if (empty($data['body'])) {
                $data['body_error'] = 'Please enter body';
            }

            if (empty($data['title_error']) && empty($data['body_error'])) {
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post Updated');
                    redirect('posts/show/' . $data['id']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // If author of the post is not the current logged in user redirect to posts
            if ($post->user_id !== $_SESSION['user_id']) {
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            $this->view('posts/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post Deleted');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts' . $id);
        }
    }
}