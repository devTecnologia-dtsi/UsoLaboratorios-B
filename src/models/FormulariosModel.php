<?php
require_once __DIR__ . '/../../connections/Connect.php';

class FormulariosModel extends Connect
{
    public function crear(array $datos): array
    {
        try {
            $resultado = $this->query("CALL GestionarFormularios(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                'CREAR',                    // 1. Acción
                null,                       // 2. IdFormulario (NULL para crear)
                $datos['IdUsuarios'] ?? 1,  // 3. IdUsuarios
                $datos['IdSalones'] ?? 1,   // 4. IdSalones
                $datos['IdTiposPractica'] ?? 1, // 5. IdTiposPractica
                $datos['IdRecursos'] ?? 1,  // 6. IdRecursos
                $datos['IdProgramasXCO'] ?? 1, // 7. IdProgramasXCO
                $datos['FechaPractica'] ?? '2024-01-01', // 8. FechaPractica
                $datos['HoraEntrada'] ?? '08:00:00', // 9. HoraEntrada
                $datos['HoraSalida'] ?? '10:00:00', // 10. HoraSalida
                $datos['EstudiantesPractica'] ?? 0, // 11. EstudiantesPractica
                $datos['ProfesoresPractica'] ?? 1   // 12. ProfesoresPractica
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }

    public function listar(): array
    {
        try {
            $resultado = $this->query("CALL GestionarFormularios(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                'LISTAR', null, null, null, null, null, null, null, null, null, null, null
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }

    public function buscar(int $idFormulario): array
    {
        try {
            $resultado = $this->query("CALL GestionarFormularios(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                'BUSCAR', $idFormulario, null, null, null, null, null, null, null, null, null, null
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }

    public function editar(int $idFormulario, array $datos): array
    {
        try {
            $resultado = $this->query("CALL GestionarFormularios(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                'EDITAR',                   // 1. Acción
                $idFormulario,              // 2. IdFormulario
                $datos['IdUsuarios'] ?? null, // 3. IdUsuarios
                $datos['IdSalones'] ?? null, // 4. IdSalones
                $datos['IdTiposPractica'] ?? null, // 5. IdTiposPractica
                $datos['IdRecursos'] ?? null, // 6. IdRecursos
                $datos['IdProgramasXCO'] ?? null, // 7. IdProgramasXCO
                $datos['FechaPractica'] ?? null, // 8. FechaPractica
                $datos['HoraEntrada'] ?? null, // 9. HoraEntrada
                $datos['HoraSalida'] ?? null, // 10. HoraSalida
                $datos['EstudiantesPractica'] ?? null, // 11. EstudiantesPractica
                $datos['ProfesoresPractica'] ?? null  // 12. ProfesoresPractica
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}