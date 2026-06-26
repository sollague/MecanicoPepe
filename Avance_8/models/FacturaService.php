<?php

require_once __DIR__ . '/MecanicoPepe.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/Logger.php';

/**
 * Class FacturaService
 *
 * Servicio de dominio encargado de crear facturas y obtener datos relacionados
 * a mecánicos y servicios. Centraliza la lógica de negocio asociada a facturas.
 */
class FacturaService
{
    private MecanicoPepe $db;

    public function __construct(MecanicoPepe $db)
    {
        $this->db = $db;
    }

    /**
     * Obtiene un mecánico por su ID.
     */
    public function findMecanico(int $id): ?array
    {
        $result = $this->db->executeQuery('SELECT * FROM mecanicos WHERE id = ?', [$id]);
        return $result[0] ?? null;
    }

    /**
     * Obtiene los servicios seleccionados por ID.
     * Filtra IDs inválidos de forma segura.
     */
    public function findServicios(array $servicioIds): array
    {
        $servicios = [];

        foreach ($servicioIds as $id) {
            if (!Validator::isValidId($id)) {
                continue;
            }

            $resultado = $this->db->executeQuery('SELECT * FROM servicios WHERE id = ?', [(int) $id]);

            if (!empty($resultado)) {
                $servicios[] = $resultado[0];
            }
        }

        return $servicios;
    }

    /**
     * Crea una factura y sus detalles en la base de datos.
     * Utiliza transacciones para garantizar la atomicidad del proceso.
     */
    public function createFactura(array $clienteData, int $mecanicoId, array $servicios, string $tipoMantenimiento, string $trabajos, string $fecha, ?string $responsable = null): int
    {
        $total = 0;

        foreach ($servicios as $servicio) {
            $total += (float) ($servicio['precio'] ?? 0);
        }

        $subtotal = round($total, 2);
        $iva = round($subtotal * 0.15, 2);
        $totalFinal = round($subtotal + $iva, 2);

        $this->db->beginTransaction();

        // Registrar inicio de operación para gestión de cambios
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $responsable = $responsable ?? ($_SESSION['usuario'] ?? 'system');

        Logger::audit([
            'responsable' => $responsable,
            'modulo' => 'facturas',
            'accion' => 'crear_factura',
            'descripcion' => 'Inicio de creación de factura',
            'detalle' => [
                'cliente' => $clienteData['cliente'] ?? '',
                'mecanico_id' => $mecanicoId,
                'servicios_count' => count($servicios),
            ],
            'resultado' => 'started',
        ]);

        try {
            $sqlFactura = 'INSERT INTO facturas
                (cliente, cedula, correo, telefono, vehiculo, mecanico_id, tipo_mantenimiento, trabajos, total, fecha)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $this->db->executeNonQueryPrepared($sqlFactura, [
                Validator::sanitizeText($clienteData['cliente']),
                Validator::sanitizeText($clienteData['cedula']),
                Validator::sanitizeText($clienteData['correo']),
                Validator::sanitizeText($clienteData['telefono']),
                Validator::sanitizeText($clienteData['vehiculo']),
                $mecanicoId,
                Validator::sanitizeText($tipoMantenimiento),
                Validator::sanitizeText($trabajos),
                $totalFinal,
                $fecha,
            ]);

            $facturaId = $this->db->getLastInsertId();

            foreach ($servicios as $servicio) {
                $this->db->executeNonQueryPrepared(
                    'INSERT INTO detalle_factura (factura_id, servicio_id, precio) VALUES (?, ?, ?)',
                    [
                        $facturaId,
                        (int) $servicio['id'],
                        (float) $servicio['precio'],
                    ]
                );
            }

            $this->db->commit();

            Logger::audit([
                'responsable' => $responsable,
                'modulo' => 'facturas',
                'accion' => 'crear_factura',
                'descripcion' => 'Factura creada con éxito',
                'detalle' => ['factura_id' => $facturaId, 'total' => $totalFinal],
                'resultado' => 'success',
            ]);

            return $facturaId;
        } catch (Exception $e) {
            $this->db->rollback();
            Logger::error('Error al crear factura: ' . $e->getMessage());
            Logger::audit([
                'responsable' => $responsable,
                'modulo' => 'facturas',
                'accion' => 'crear_factura',
                'descripcion' => 'Error al crear factura',
                'detalle' => ['error' => $e->getMessage()],
                'resultado' => 'failed',
            ]);

            throw $e;
        }
    }
}
