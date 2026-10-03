<?php

class Controller
{
    public function model($name)
    {
        require_once __DIR__ . "/../MVC/Models/$name.php";
        return new $name;
    }

    public function view($view, $data = [])
    {
        require_once __DIR__ . "/../MVC/Views/$view.php";
    }
}