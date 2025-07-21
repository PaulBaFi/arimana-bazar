<?php
require_once "models/ProveedorModel.php";
require_once "models/EmpresaModel.php";

class ProveedorController
{
    private $model;

    public function __construct()
    {
        $this->model = new ProveedorModel();
    }

    public function index()
    {
        $proveedores = $this->model->getAll();
        include "views/proveedores/index.php";
    }

    public function create()
    {
        $empresaModel = new EmpresaModel();
        $empresas = $empresaModel->getAllActive();

        require_once 'views/proveedores/form.php';
    }

    public function store($data)
    {
        if (empty($data['id_empresa'])) {
            header("Location: index.php?controller=proveedor&action=create&error=campos_vacios");
            return;
        }

        /* validaciones */

        $data = [
            'id_empresa' => $_POST['id_empresa']
        ];

        $proveedorModel = new ProveedorModel();
        $proveedorModel->insert($data);

        header("Location: index.php?controller=proveedor&action=index&msg=creado");
    }

    public function edit($id)
    {
        $proveedorModel = new ProveedorModel();
        $empresaModel = new EmpresaModel();

        $proveedor = $proveedorModel->getById($id);
        $empresa = $empresaModel->getById($proveedor['id_empresa']);

        $empresas = $empresaModel->getAll();

        require_once "views/proveedores/form.php";
    }

    public function update($data)
    {
        if (empty($data['razonsocial']) || empty($data['ruc']) || empty($data['correo']) || empty($data['telefono']) || empty($data['direccion'])) {
            header("Location: index.php?controller=proveedor&action=edit&id=" . $data['id_proveedor'] . "&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=proveedor&action=edit&id=" . $data['id_proveedor'] . "&error=email_invalido");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=proveedor&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=proveedor&action=index&msg=eliminado");
    }
}
