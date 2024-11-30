<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Проверяем, существует ли контроллер, который указан в URL
        if (isset($url[0]) && file_exists(ROOT_DIR . '/app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . 'Controller';
            unset($url[0]);
        }

        // Подключаем контроллер
        require_once ROOT_DIR . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Проверяем, существует ли метод в контроллере
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Параметры
        $this->params = $url ? array_values($url) : [];

        // Вызываем метод контроллера с параметрами
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        // Разделяем URL на части
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
