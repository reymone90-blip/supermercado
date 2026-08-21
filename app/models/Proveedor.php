<?php
class Proveedor
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM proveedores ORDER BY nombre")->fetchAll();
    }

    public function activos()
    {
        return $this->pdo->query("SELECT * FROM proveedores WHERE activo = 1 ORDER BY nombre")->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO proveedores (nombre, contacto, telefono, direccion)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$data['nombre'], $data['contacto'], $data['telefono'], $data['direccion']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE proveedores SET nombre=?, contacto=?, telefono=?, direccion=? WHERE id=?
        ");
        $stmt->execute([$data['nombre'], $data['contacto'], $data['telefono'], $data['direccion'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM proveedores WHERE id = ?");
        $stmt->execute([$id]);
    }
}
