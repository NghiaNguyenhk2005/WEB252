<?php

/**
 * Controller cơ sở cung cấp các hàm hỗ trợ hiển thị view và điều hướng
 */
class BaseController
{
    /**
     * Nạp giao diện và truyền dữ liệu
     */
    protected function view($path, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../../views/' . $path . '.php';
    }

    /**
     * Điều hướng URL
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}