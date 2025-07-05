<?php
require_once "models/VentaModel.php";

class VentaController
{
    private $model;

    public function __construct()
    {
        $this->model = new VentaModel();
    }

    public function index()
    {
        $ventas = $this->model->getAll();
        include "views/ventas/index.php";
    }

    public function create()
    {
        include "views/ventas/form.php";
    }
}
