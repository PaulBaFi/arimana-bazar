<?php

$controllerName = $_GET['controller'] ?? 'panel';
$action = $_GET['action'] ?? 'index';

switch ($controllerName) {
    case 'landing':
        require_once "controllers/LandingController.php";
        $controller = new LandingController();
        break;
    case 'panel':
        require_once "controllers/PanelController.php";
        $controller = new PanelController();
        break;
    case 'usuario':
        require_once "controllers/UsuarioController.php";
        $controller = new UsuarioController();
        break;
    case 'pedido':
        require_once "controllers/PedidoController.php";
        $controller = new PedidoController();
        break;
    case 'proveedor':
        require_once "controllers/ProveedorController.php";
        $controller = new ProveedorController();
        break;
    case 'producto':
        require_once "controllers/ProductoController.php";
        $controller = new ProductoController();
        break;
    case 'categoria':
        require_once "controllers/CategoriaController.php";
        $controller = new CategoriaController();
        break;
    case 'venta':
        require_once "controllers/VentaController.php";
        $controller = new VentaController();
        break;
    case 'cliente':
        require_once "controllers/ClienteController.php";
        $controller = new ClienteController();
        break;
    case 'persona':
        require_once "controllers/PersonaController.php";
        $controller = new PersonaController();
        break;
    case 'empresa':
        require_once "controllers/EmpresaController.php";
        $controller = new EmpresaController();
        break;
    default:
        echo "Controlador no válido";
        exit;
}

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'search':
        $controller->search($_GET['buscar'] ?? '');
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store($_POST);
        break;
    case 'edit':
        $controller->edit($_GET['id']);
        break;
    case 'update':
        $controller->update($_POST);
        break;
    case 'delete':
        $controller->delete($_GET['id']);
        break;
    case 'form':
        $controller->form();
        break;
    case 'detalle':
        $controller->detalle();
        break;
    default:
        echo "Acción no válida";
}