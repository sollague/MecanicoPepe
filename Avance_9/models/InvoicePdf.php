<?php

/**
 * Class InvoicePdf
 *
 * Genera un PDF básico de factura sin dependencias externas.
 */
class InvoicePdf
{
    private static function escapeText(string $text): string
    {
        $text = utf8_decode($text);
        $text = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
        return $text;
    }

    private static function createObject(int $id, string $content): string
    {
        return "$id 0 obj\n$content\nendobj\n";
    }

    private static function createStreamObject(int $id, string $stream): string
    {
        $length = strlen($stream);
        return "$id 0 obj\n<< /Length $length >>\nstream\n$stream\nendstream\nendobj\n";
    }

    public static function build(array $invoice): string
    {
        $lines = [];
        $lines[] = 'BT';
        $lines[] = '/F1 20 Tf';
        $lines[] = '50 800 Td';
        $lines[] = '(' . self::escapeText('Factura MecanicoPepe') . ') Tj';
        $lines[] = '/F1 12 Tf';
        $lines[] = '0 -24 Td';
        $lines[] = '(' . self::escapeText('Factura #: ' . ($invoice['factura_id'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Fecha: ' . ($invoice['fecha'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Cliente: ' . ($invoice['cliente'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Cédula: ' . ($invoice['cedula'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Correo: ' . ($invoice['correo'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Teléfono: ' . ($invoice['telefono'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Vehículo: ' . ($invoice['vehiculo'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Mecánico: ' . ($invoice['mecanico']['nombre'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Tipo de mantenimiento: ' . ($invoice['tipo_mantenimiento'] ?? '-')) . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '(' . self::escapeText('Trabajos realizados:') . ') Tj';
        $lines[] = '0 -18 Td';
        $trabajos = wordwrap($invoice['trabajos'] ?? '', 80, '\n');
        foreach (explode("\n", $trabajos) as $trabajoLine) {
            $lines[] = '(' . self::escapeText(trim($trabajoLine)) . ') Tj';
            $lines[] = '0 -16 Td';
        }

        $lines[] = 'ET';

        $y = 420;
        $lines[] = 'BT';
        $lines[] = '/F1 14 Tf';
        $lines[] = '50 ' . $y . ' Td';
        $lines[] = '(' . self::escapeText('Servicios incluidos:') . ') Tj';
        $lines[] = '0 -18 Td';
        $lines[] = '/F1 12 Tf';
        $lines[] = '(' . self::escapeText('Servicio') . ') Tj';
        $lines[] = '220 0 Td';
        $lines[] = '(' . self::escapeText('Precio') . ') Tj';
        $lines[] = '0 -16 Td';

        foreach ($invoice['servicios'] as $servicio) {
            $serviceLine = self::escapeText($servicio['nombre'] ?? '');
            $priceLine = '$' . number_format((float) ($servicio['precio'] ?? 0), 2);
            $lines[] = '(' . $serviceLine . ') Tj';
            $lines[] = '220 0 Td';
            $lines[] = '(' . self::escapeText($priceLine) . ') Tj';
            $lines[] = '0 -16 Td';
        }

        $lines[] = 'ET';
        $lines[] = 'BT';
        $lines[] = '/F1 12 Tf';
        $lines[] = '50 120 Td';
        $lines[] = '(' . self::escapeText('Subtotal: $' . number_format((float) ($invoice['subtotal'] ?? 0), 2)) . ') Tj';
        $lines[] = '0 -16 Td';
        $lines[] = '(' . self::escapeText('IVA 15%: $' . number_format((float) ($invoice['iva'] ?? 0), 2)) . ') Tj';
        $lines[] = '0 -16 Td';
        $lines[] = '(' . self::escapeText('TOTAL: $' . number_format((float) ($invoice['total'] ?? 0), 2)) . ') Tj';
        $lines[] = 'ET';

        $contentStream = implode("\n", $lines);

        $objects = [];
        $objects[] = self::createObject(1, '<< /Type /Catalog /Pages 2 0 R >>');
        $objects[] = self::createObject(2, '<< /Type /Pages /Kids [3 0 R] /Count 1 >>');
        $pageContent = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>';
        $objects[] = self::createObject(3, $pageContent);
        $objects[] = self::createObject(4, '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');
        $objects[] = self::createStreamObject(5, $contentStream);

        $pdf = "%PDF-1.4\n%âãÏÓ\n";
        $offsets = [];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
        foreach ($offsets as $offset) {
            $xref .= sprintf('%010d 00000 n \n', $offset);
        }

        $pdf .= $xref;
        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n";
        $pdf .= strlen($pdf);
        $pdf .= "\n%%EOF";

        return $pdf;
    }
}
