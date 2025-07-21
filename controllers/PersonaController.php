<?php
require_once "models/PersonaModel.php";

class PersonaController
{
    private $model;

    public function __construct()
    {
        $this->model = new PersonaModel();
    }

    /*public function index()
    {
        $personas = $this->model->getAll();
        include "views/personas/index.php";
    }*/

    public function index()
    {
        if (isset($_GET['buscar']) && !empty(trim($_GET['buscar']))) {
            $personas = $this->model->search($_GET['buscar']);
        } else {
            $personas = $this->model->getAll();
        }
        include "views/personas/index.php";
    }

    public function search($keyword)
    {
        $personas = $this->model->search($keyword);
        include "views/personas/index.php";
    }

    public function create()
    {
        include "views/personas/form.php";
    }

    public function store($data)
    {
        if (empty($data['nombres']) || empty($data['apellidos']) || empty($data['dni'])) {
            header("Location: index.php?controller=persona&action=create&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=persona&action=create&error=email_invalido");
            return;
        }

        /* validaciones */

        $this->model->insert($data);
        header("Location: index.php?controller=persona&action=index&msg=creado");
    }

    public function edit($id)
    {
        $persona = $this->model->getById($id);
        include "views/personas/form.php";
    }

    public function update($data)
    {
        if (empty($data['nombres']) || empty($data['apellidos']) || empty($data['correo'])) {
            header("Location: index.php?controller=persona&action=edit&id=" . $data['id_persona'] . "&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=persona&action=edit&id=" . $data['id_persona'] . "&error=email_invalido");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=persona&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=persona&action=index&msg=eliminado");
    }
}