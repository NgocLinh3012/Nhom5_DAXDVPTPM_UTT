<?php

class App
{
    public function __construct()
    {
        $url = $_GET["url"] ?? "HomeController/index";

        $arr = explode("/", trim($url, "/"));

        $controller = $arr[0] ?? "HomeController";
        $action = $arr[1] ?? "index";
        $params = array_slice($arr, 2);

        $file = __DIR__ . "/../MVC/Controllers/$controller.php";

        if (!file_exists($file)) {
            die("Không tìm thấy Controller: $controller");
        }

        require_once $file;

        $c = new $controller;

        if (!method_exists($c, $action)) {
            die("Không tìm thấy Action: $action");
        }

        call_user_func_array([$c, $action], $params);
    }
}