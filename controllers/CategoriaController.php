<?php
require_once "models/CategoriaModel.php";

class CategoriaController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoriaModel();
    }

    public function index()
    {
        $categorias = $this->model->getAll();
        include "views/categorias/index.php";
    }

    public function create()
    {
        include "views/categorias/form.php";
    }

    public function store($data)
    {
        if (empty($data['nom_cat'])) {
            header("Location: index.php?controller=categoria&action=create&error=campos_vacios");
            return;
        }

        $this->model->insert($data);
        header("Location: index.php?controller=categoria&action=index&msg=creado");
    }

    public function edit($id)
    {
        $categoria = $this->model->getById($id);
        include "views/categorias/form.php";
    }

    public function update($data)
    {
        if (empty($data['nom_cat']) || empty($data['id_categoria'])) {
            header("Location: index.php?controller=categoria&action=edit&id=" . ($data['id_categoria'] ?? '') . "&error=campos_vacios");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=categoria&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=categoria&action=index&msg=eliminado");
    }
}
