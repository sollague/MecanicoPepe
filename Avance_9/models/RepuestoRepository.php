<?php

require_once __DIR__ . '/MecanicoPepe.php';
require_once __DIR__ . '/Validator.php';

/**
 * Class RepuestoRepository
 *
 * Repositorio para las operaciones CRUD de repuestos. Utiliza el modelo
 * `MecanicoPepe` para ejecutar consultas y aplica sanitización básica.
 */
class RepuestoRepository
{
    private MecanicoPepe $db;

    public function __construct(MecanicoPepe $db)
    {
        $this->db = $db;
    }

    /**
     * Inserta un nuevo repuesto en la tabla repuestos.
     */
    public function create(string $nombre, float $precio, int $stock): bool
    {
        $sql = 'INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)';

        return $this->db->executeNonQueryPrepared($sql, [
            Validator::sanitizeText($nombre),
            $precio,
            $stock,
        ]);
    }

    /**
     * Actualiza los datos de un repuesto existente.
     */
    public function update(int $id, string $nombre, float $precio, int $stock): bool
    {
        $sql = 'UPDATE repuestos SET nombre = ?, precio = ?, stock = ? WHERE id = ?';

        return $this->db->executeNonQueryPrepared($sql, [
            Validator::sanitizeText($nombre),
            $precio,
            $stock,
            $id,
        ]);
    }

    /**
     * Elimina un repuesto por su ID.
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM repuestos WHERE id = ?';

        return $this->db->executeNonQueryPrepared($sql, [$id]);
    }

    /**
     * Busca un repuesto por ID y devuelve un registro o null.
     */
    public function findById(int $id): ?array
    {
        $sql = 'SELECT * FROM repuestos WHERE id = ? LIMIT 1';
        $result = $this->db->executeQuery($sql, [$id]);

        return $result[0] ?? null;
    }
}
