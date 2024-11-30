<?php

class Controller {
    public function view($view, $data = []) {
        $viewPath = ROOT_DIR . '/app/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die('View does not exist: ' . $viewPath);
        }
    }
}
