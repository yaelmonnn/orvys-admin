<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaModel extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [];


    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fr';


    protected $skipValidation = true;
    protected $cleanValidationRules = true;


    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function traerEstados() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Estados";
            $result = $db->query($sql);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function traerUrgencias() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Urgencias";
            $result = $db->query($sql);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function traerCargos() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Cargos";
            $result = $db->query($sql);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function traerComplejidad() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Complejidad";
            $result = $db->query($sql);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function insertarTarea($data)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Insertar_Tarea 
                @nombre = ?, 
                @cargo = ?, 
                @urgencia = ?, 
                @complejidad = ?, 
                @descripcion = ?, 
                @modulo = ?,
                @duracion = ?, 
                @estatus = ?, 
                @observaciones_tec = ?, 
                @adicionales = ?, 
                @pruebas_unitarias = ?,
                @usuario = ?,
                @proyecto_id = ?, 
                @sprint_id = ?, 
                @fr_inicio = ?,  
                @fr_fin = ?,
                @grupo_asignado = ?",
                [
                    $data['nombre'],
                    $data['cargo'],
                    $data['urgencia'],
                    $data['complejidad'],
                    $data['descripcion'],
                    $data['modulo'],
                    $data['duracion'],
                    $data['estatus'],
                    $data['observaciones_tec'],
                    $data['adicionales'],
                    $data['pruebas_unitarias'],
                    $data['usuario'],
                    $data['proyecto_id'],
                    $data['sprint_id'],
                    $data['fr_inicio'],
                    $data['fr_fin'],
                    $data['grupo_asignado']
                ]
            );
            return [
                'success' => true,
                'resultado' => $query->getRowArray()['Resultado'] ?? 'CORRECTO'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function traerProductBacklog($idProyecto)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Tareas_Proyecto ?", [$idProyecto]);
            return $query->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function traerSprintBacklog($idProyecto, $idEtapa, $idSprint)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Tareas_Etapa_Proyecto ?, ?, ?", [$idProyecto, $idEtapa, $idSprint]);
            return $query->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function traerSprintCompleto($idProyecto, $idSprint)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Tareas_Sprint_Proyecto ?, ?", [$idProyecto, $idSprint]);
            return $query->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }


    public function traerEtapas()
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Traer_Etapas");
            return $query->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function traerSprints($idProyecto) {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_SprintsXProyecto ?";
            $result = $db->query($sql, [$idProyecto]);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function avanzarTarea($etapaActualId, $idTarea)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Avanzar_Tareas @etapa_act_id = ?, @id_tarea = ?", [$etapaActualId, $idTarea]);
            $resultado = $query->getRow();

            if (isset($resultado->Resultado)) {
                return [
                    'success' => $resultado->Resultado === 'CORRECTO',
                    'message' => $resultado->Resultado
                ];
            }

            return [
                'success' => false,
                'message' => 'Sin respuesta del procedimiento almacenado.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ];
        }
    }

    public function retrocederTarea($etapaActualId, $idTarea)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Retroceder_Tareas @etapa_act_id = ?, @id_tarea = ?", [$etapaActualId, $idTarea]);
            $resultado = $query->getRow();

            if (isset($resultado->Resultado)) {
                return [
                    'success' => $resultado->Resultado === 'CORRECTO',
                    'message' => $resultado->Resultado
                ];
            }

            return [
                'success' => false,
                'message' => 'Sin respuesta del procedimiento almacenado.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ];
        }
    }


    public function eliminarTarea($idTarea)
    {
        $db = \Config\Database::connect();

        try {
            $query = $db->query("EXEC pa_Eliminar_Tarea @tarea_id = ?", [$idTarea]);
            $resultado = $query->getRow();

            if (isset($resultado->Resultado)) {
                return [
                    'success' => $resultado->Resultado === 'CORRECTO',
                    'message' => $resultado->Resultado
                ];
            }

            return [
                'success' => false,
                'message' => 'Error desconocido al eliminar la tarea.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error interno en el servidor.'
            ];
        }
    }






}