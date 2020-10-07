<?php

class Pages extends Controller {
    public function __construct() {
        $this->postModel = $this->model('Post');
    }

    public function index() {
        $data = [
            'title' => 'Welcome',
        ];
        $this->view('pages/index', $data);
    }

    public function about() {
        $this->view('pages/about', ['title' => 'Hello World']);
    }
}