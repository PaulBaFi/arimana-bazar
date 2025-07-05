<?php

require_once "models/PrincipalModel.php";

class PrincipalController
{
    private $model;

    public function __construct()
    {
        $this->model = new PrincipalModel();
    }

    public function index()
    {
        $userName = $this->model->getUserName();
        include "views/principal/index.php";
    }

    // Aquí puedes agregar más métodos para manejar otras funcionalidades del controlador principal
}
