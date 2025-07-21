<?php
require_once "models/ProductoModel.php";
require_once "models/CategoriaModel.php";

class ProductoController
{
    private $model;

    public function __construct()
    {
        $this->model = new ProductoModel();
    }

    public function index()
    {
        $productos = $this->model->getAll();
        include "views/productos/index.php";
    }

    public function create()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->getAll();

        include "views/productos/form.php";
    }

    public function store($data)
    {
        if (empty($data['id_categoria']) || empty($data['nom_prod']) || empty($data['descripcion_prod']) || empty($data['existencia']) || empty($data['precio'])) {
            header("Location: index.php?controller=producto&action=create&error=campos_vacios");
            return;
        }

        if (!is_numeric($data['existencia']) || !is_numeric($data['precio'])) {
            header("Location: index.php?controller=producto&action=create&error=datos_invalidos");
            return;
        }

        $this->model->insert($data);
        header("Location: index.php?controller=producto&action=index&msg=creado");
    }

    public function edit($id)
    {
        $id = $_GET['id'];
        $productoModel = new ProductoModel();
        $producto = $productoModel->getById($id);

        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->getAll();
        include "views/productos/form.php";
    }

    public function update($data)
    {
        if (empty($data['id_categoria']) || empty($data['nom_prod']) || empty($data['descripcion_prod']) || empty($data['existencia']) || empty($data['precio'])) {
            header("Location: index.php?controller=producto&action=edit&id=" . $data['id_producto'] . "&error=campos_vacios");
            return;
        }

        if (!is_numeric($data['existencia']) || !is_numeric($data['precio'])) {
            header("Location: index.php?controller=producto&action=edit&id=" . $data['id_producto'] . "&error=datos_invalidos");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=producto&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=producto&action=index&msg=eliminado");
    }
}
