<?php
require_once "models/EmpresaModel.php";

class EmpresaController
{
    private $model;

    public function __construct()
    {
        $this->model = new EmpresaModel();
    }

    public function index()
    {
        $empresas = $this->model->getAll();
        include "views/empresas/index.php";
    }

    public function create()
    {
        include "views/empresas/form.php";
    }

    public function store($data)
    {
        if (empty($data['razonsocial']) || empty($data['ruc']) || empty($data['correo']) || empty($data['telefono']) || empty($data['direccion'])) {
            header("Location: index.php?controller=empresa&action=create&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=empresa&action=create&error=email_invalido");
            return;
        }

        /* validaciones */

        $this->model->insert($data);
        header("Location: index.php?controller=empresa&action=index&msg=creado");
    }

    public function edit($id)
    {
        $empresa = $this->model->getById($id);
        include "views/empresas/form.php";
    }

    public function update($data)
    {
        if (empty($data['razonsocial']) || empty($data['ruc']) || empty($data['correo']) || empty($data['telefono']) || empty($data['direccion'])) {
            header("Location: index.php?controller=empresa&action=edit&id=" . $data['id_empresa'] . "&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=empresa&action=edit&id=" . $data['id_empresa'] . "&error=email_invalido");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=empresa&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=empresa&action=index&msg=eliminado");
    }
}
