<?php

class BaseController
{
    protected function view($path, $data = [])
    {
        extract($data);

        require_once __DIR__ . '/../../views/' . $path . '.php';
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}