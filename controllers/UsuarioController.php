<?php
require_once "models/UsuarioModel.php";
require_once "models/PersonaModel.php";

class UsuarioController
{
    private $model;

    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    public function index()
    {
        $usuarios = $this->model->getAll();
        include "views/usuario/index.php";
    }

    public function create()
    {
        $personaModel = new PersonaModel();
        $personas = $personaModel->getAll();

        include "views/usuario/form.php";
    }

    public function store($data)
    {
        if (empty($data['id_persona']) || empty($data['correo']) || empty($data['clave']) || empty($data['rol'])) {
            header("Location: index.php?controller=usuario&action=create&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=usuario&action=create&error=email_invalido");
            return;
        }

        $existingUser = $this->model->getByEmail($data['correo']);
        if ($existingUser) {
            header("Location: index.php?controller=usuario&action=create&error=correo_existente");
            return;
        }

        $this->model->insert($data);
        header("Location: index.php?controller=usuario&action=index&msg=creado");
    }

    public function edit($id)
    {
        $id = $_GET['id'];
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->getById($id);

        $personaModel = new PersonaModel();
        $personas = $personaModel->getAll();

        include "views/usuario/form.php";
    }

    public function update($data)
    {
        if (empty($data['id_persona']) || empty($data['correo']) || empty($data['clave']) || empty($data['rol'])) {
            header("Location: index.php?controller=usuario&action=create&error=campos_vacios");
            return;
        }

        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?controller=usuario&action=edit&id=" . $data['id_usuario'] . "&error=email_invalido");
            return;
        }

        $this->model->update($data);
        header("Location: index.php?controller=usuario&action=index&msg=actualizado");
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php?controller=usuario&action=index&msg=eliminado");
    }
}
