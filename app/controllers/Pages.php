<?php

class Pages extends Controller {
    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    public function index() {
        if (isLoggedIn()) {
            redirect('posts');
        }

        $data = [
            'title' => 'SharePosts',
            'description' => 'Simple social network build on lkkmvc'
        ];
        $this->view('pages/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];
        $this->view('pages/about', $data);
    }
}