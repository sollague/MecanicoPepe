<?php

require_once __DIR__ . '/MecanicoPepe.php';
require_once __DIR__ . '/Validator.php';

class VehiculoRepository
{
    private MecanicoPepe $db;

    public function __construct(MecanicoPepe $db)
    {
        $this->db = $db;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO vehiculos (marca, modelo, anio, placa, propietario) VALUES (?, ?, ?, ?, ?)';

        return $this->db->executeNonQueryPrepared($sql, [
            Validator::sanitizeText($data['marca']),
            Validator::sanitizeText($data['modelo']),
            (int) $data['anio'],
            Validator::sanitizeText($data['placa']),
            Validator::sanitizeText($data['propietario']),
        ]);
    }

    public function update(array $data): bool
    {
        $sql = 'UPDATE vehiculos SET marca = ?, modelo = ?, anio = ?, placa = ?, propietario = ? WHERE id = ?';

        return $this->db->executeNonQueryPrepared($sql, [
            Validator::sanitizeText($data['marca']),
            Validator::sanitizeText($data['modelo']),
            (int) $data['anio'],
            Validator::sanitizeText($data['placa']),
            Validator::sanitizeText($data['propietario']),
            (int) $data['id'],
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM vehiculos WHERE id = ?';
        return $this->db->executeNonQueryPrepared($sql, [$id]);
    }
}
