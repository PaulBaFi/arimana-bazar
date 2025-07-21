<?php
require_once "models/ClienteModel.php";
require_once 'models/PersonaModel.php';
require_once 'models/EmpresaModel.php';

class ClienteController
{
    private $clienteModel;
    private $personaModel;
    private $empresaModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->personaModel = new PersonaModel();
        $this->empresaModel = new EmpresaModel();
    }

    public function index()
    {
        $clientes = $this->clienteModel->getAll();
        include "views/clientes/index.php";
    }

    public function create()
    {
        require 'views/clientes/form.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        $cliente = $this->clienteModel->getById($id);
        require 'views/clientes/form.php';
    }

    public function store()
    {
        if (!isset($_POST['tipo_cliente'])) {
            echo "Tipo de cliente no especificado.";
            exit;
        }
        $tipo = $_POST['tipo_cliente'];

        if ($tipo === 'persona') {
            $id_persona = $this->personaModel->insert([
                'nombres' => $_POST['nombres'],
                'apellidos' => $_POST['apellidos'],
                'dni' => $_POST['dni'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            ]);

            $this->clienteModel->insert(['id_persona' => $id_persona]);
        } elseif ($tipo === 'empresa') {
            $id_empresa = $this->empresaModel->insert([
                'razonsocial' => $_POST['razonsocial'],
                'ruc' => $_POST['ruc'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            ]);

            $this->clienteModel->insert(['id_empresa' => $id_empresa]);
        } else {
            throw new Exception("Tipo de cliente inválido.");
        }

        header('Location: index.php?controller=cliente&action=index');
    }

    public function update()
    {
        if (!isset($_POST['tipo_cliente'])) {
            echo "Tipo de cliente no especificado.";
            exit;
        }
        $id_cliente = $_POST['id_cliente'];
        $tipo = $_POST['tipo_cliente'];

        $this->clienteModel->update($id_cliente, $_POST);

        if ($tipo === 'persona') {
            $this->personaModel->update($_POST['id_persona'], [
                'nombres' => $_POST['nombres'],
                'apellidos' => $_POST['apellidos'],
                'dni' => $_POST['dni'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            ]);
        } elseif ($tipo === 'empresa') {
            $this->empresaModel->update($_POST['id_empresa'], [
                'razonsocial' => $_POST['razonsocial'],
                'ruc' => $_POST['ruc'],
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            ]);
        }

        header('Location: index.php?controller=cliente&action=index');
    }

    public function delete()
    {
        $id_cliente = $_GET['id'];

        $this->clienteModel->delete($id_cliente);

        try {
            $this->clienteModel->delete($id_cliente);
            header('Location: index.php?controller=cliente&action=index&status=success');
        } catch (Exception $e) {
            header('Location: index.php?controller=cliente&action=index&status=error');
        }
    }

    public function form()
    {
        $id = $_GET['id'] ?? null;
        $tipo = $_GET['tipo'] ?? null;

        if ($id) {
            $cliente = $this->clienteModel->getById($id);
            $tipo = $cliente['tipo_cliente'] ?? null;

            if (!$cliente || !$tipo) {
                header('Location: index.php?controller=cliente&action=index&status=no_encontrado');
                exit;
            }
        } else {
            if ($tipo === 'persona') {
                $personas = $this->personaModel->getAll();
            } elseif ($tipo === 'empresa') {
                $empresas = $this->empresaModel->getAll();
            } else {
                echo "Tipo de cliente no especificado. Agrega ?tipo=persona o ?tipo=empresa en la URL.";
                exit;
            }
        }

        require 'views/clientes/form.php';
    }
}
