<?php
class Usuario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function verificar($usuario, $clave)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM usuarios WHERE usuario = ? AND activo = 1
        ");
        $stmt->execute([$usuario]);
        $fila = $stmt->fetch();

        if ($fila && $fila['clave'] === hash('sha256', $clave)) {
            return $fila;
        }
        return false;
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function all()
    {
        return $this->pdo->query("SELECT * FROM usuarios ORDER BY nombre")->fetchAll();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (nombre, usuario, clave, rol)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['usuario'],
            hash('sha256', $data['clave']),
            $data['rol'],
        ]);
    }

    public function update($id, $data)
    {
        // Si viene clave nueva, la actualiza también. Si no, deja la actual.
        if (!empty($data['clave'])) {
            $stmt = $this->pdo->prepare("
                UPDATE usuarios SET nombre=?, usuario=?, clave=?, rol=? WHERE id=?
            ");
            $stmt->execute([$data['nombre'], $data['usuario'], hash('sha256', $data['clave']), $data['rol'], $id]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE usuarios SET nombre=?, usuario=?, rol=? WHERE id=?
            ");
            $stmt->execute([$data['nombre'], $data['usuario'], $data['rol'], $id]);
        }
    }

    public function toggleActivo($id)
    {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET activo = NOT activo WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function existeUsuario($usuario, $excluirId = null)
    {
        if ($excluirId) {
            $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE usuario = ? AND id != ?");
            $stmt->execute([$usuario, $excluirId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
        }
        return (bool) $stmt->fetch();
    }
}
