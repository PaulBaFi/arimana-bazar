<?php
require_once "models/conexion.php";

class ClienteModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT 
            C.id_cliente,
            CASE 
                WHEN P.id_persona IS NOT NULL THEN 'persona'
                ELSE 'empresa' 
            END AS tipo_cliente,
            CASE 
                WHEN P.id_persona IS NOT NULL THEN CONCAT_WS(' ', P.nombres, P.apellidos)
                ELSE E.razonsocial 
            END AS nomcliente,
            COALESCE(P.dni, E.ruc) AS documento,
            COALESCE(P.correo, E.correo) AS correo,
            COALESCE(P.telefono, E.telefono) AS telefono,
            COALESCE(P.direccion, E.direccion) AS direccion
        FROM Cliente C
        LEFT JOIN Persona P ON C.id_persona = P.id_persona
        LEFT JOIN Empresa E ON C.id_empresa = E.id_empresa;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT 
            C.id_cliente,
            CASE 
                WHEN P.id_persona IS NOT NULL THEN 'persona'
                ELSE 'empresa' 
            END AS tipo_cliente,
            C.id_persona,
            C.id_empresa,
            P.nombres,
            P.apellidos,
            P.dni,
            P.correo AS correo_persona,
            P.telefono AS telefono_persona,
            P.direccion AS direccion_persona,
            P.nacimiento AS nacimiento_persona,
            E.razonsocial,
            E.ruc,
            E.correo AS correo_empresa,
            E.telefono AS telefono_empresa,
            E.direccion AS direccion_empresa
        FROM Cliente C
        LEFT JOIN Persona P ON C.id_persona = P.id_persona
        LEFT JOIN Empresa E ON C.id_empresa = E.id_empresa
        WHERE C.id_cliente = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function insert($data)
    {
        if (!empty($data['id_persona'])) {
            $stmt = $this->db->prepare("INSERT INTO Cliente (id_persona) VALUES (?);");
            $stmt->execute([$data['id_persona']]);
        } elseif (!empty($data['id_empresa'])) {
            $stmt = $this->db->prepare("INSERT INTO Cliente (id_empresa) VALUES (?);");
            $stmt->execute([$data['id_empresa']]);
        }
    }

    public function update($id_cliente, $data)
    {
        $stmt = $this->db->prepare("
        SELECT id_persona, id_empresa 
        FROM Cliente 
        WHERE id_cliente = ?
    ");
        $stmt->execute([$id_cliente]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente['id_persona']) {
            $stmt = $this->db->prepare("UPDATE Persona 
                SET nombres = ?, apellidos = ?, dni = ?, correo = ?, telefono = ?, direccion = ?, nacimiento = ?
                WHERE id_persona = ?
            ");
            $stmt->execute([
                $data['nombres'],
                $data['apellidos'],
                $data['dni'],
                $data['correo'],
                $data['telefono'],
                $data['direccion'],
                $data['nacimiento'],
                $cliente['id_persona']
            ]);
        } elseif ($cliente['id_empresa']) {
            $stmt = $this->db->prepare("UPDATE Empresa 
                SET razonsocial = ?, ruc = ?, correo = ?, telefono = ?, direccion = ?
                WHERE id_empresa = ?
            ");
            $stmt->execute([
                $data['razonsocial'],
                $data['ruc'],
                $data['correo'],
                $data['telefono'],
                $data['direccion'],
                $cliente['id_empresa']
            ]);
        }
    }

    public function delete($id_cliente)
    {
        $stmt = $this->db->prepare("DELETE FROM Cliente WHERE id_cliente = ?;");
        $stmt->execute([$id_cliente]);
    }
}
