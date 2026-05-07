<?php

require_once __DIR__ . '/../../models/ContactModel.php';

class ContactController
{
    private $contactModel;

    public function __construct()
    {
        global $conn;

        $this->contactModel = new ContactModel($conn);
    }

    public function index()
    {
        echo "Contact page";
    }
}