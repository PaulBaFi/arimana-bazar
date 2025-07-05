<?php

require_once "models/PanelModel.php";

class PanelController
{
    private $model;

    public function __construct()
    {
        $this->model = new PanelModel();
    }

    public function index()
    {
        $userName = $this->model->getUserName();

        $totalClientes = $this->model->getTotalClientes();
        $totalProductos = $this->model->getTotalProductos();
        $totalVentas = $this->model->getTotalVentas();
        $totalPedidos = $this->model->getTotalPedidos();
        $ventasPorMes = $this->model->getVentasPorMes();
        $productosMasVendidos = $this->model->getProductosMasVendidos();
        $stockPorCategoria = $this->model->getStockPorCategoria();

        include "views/panel/index.php";
    }

    // Aquí puedes agregar más métodos para manejar otras funcionalidades del controlador principal
}
