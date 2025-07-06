<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'titulo',
        'descripcion', 
        'cat_tipo_id', 
        'fecha_inicio',
        'fecha_fin',
        'cat_importancia_id',
        'cat_urgencia_id',
        'cat_estatus_id',
        'fr'
    ];


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


    public function traerProyectos($periodo) {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Proyectos ?";
            $result = $db->query($sql, [$periodo]);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
            
        } catch (\Throwable $th) {
            return false;
        }
    }

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

    public function traerImportancias() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Importancias";
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

    public function traerPeriodos() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Periodos";
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

    public function traerGrupos() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Grupos";
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

    public function traerTipos() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Tipos";
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

    public function insertarProyecto($data)
    {
        $db = \Config\Database::connect();

        $query = $db->query("EXEC pa_Insertar_Proyecto 
            @titulo = ?, 
            @descripcion = ?, 
            @tipo = ?, 
            @fecha_inicio = ?, 
            @fecha_fin = ?, 
            @importancia = ?, 
            @urgencia = ?, 
            @estatus = ?, 
            @periodo = ?, 
            @gruposJson = ?,
            @email = ?,
            @sprint_id = ?",
            [
                $data['titulo'],
                $data['descripcion'],
                $data['tipo'],
                $data['fecha_inicio'],
                $data['fecha_fin'],
                $data['importancia'],
                $data['urgencia'],
                $data['estatus'],
                $data['periodo'],
                $data['gruposJson'],
                $data['email'],
                $data['sprint_id']
            ]
        );

        return $query->getResultArray(); 
    }

    public function traerSprints() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Sprints";
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

    public function eliminarProyecto($id)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("EXEC pa_Eliminar_Proyecto ?", [$id]);
            $resultado = $query->getRow();

            if (isset($resultado->Resultado)) {
                return [
                    'success' => $resultado->Resultado === 'CORRECTO',
                    'message' => $resultado->Resultado
                ];
            }

            return [
                'success' => false,
                'message' => 'Respuesta inesperada del procedimiento almacenado.'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Error interno en el servidor: ' . $th->getMessage()
            ];
        }
    }

    public function editarProyecto($data)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("EXEC pa_Editar_Proyecto ?, ?, ?, ?, ?, ?, ?", [
                $data['titulo'],
                $data['descripcion'],
                $data['tipo_id'],
                $data['importancia_id'],
                $data['urgencia_id'],
                $data['estatus_id'],
                $data['proyecto_id']
            ]);

            $resultado = $query->getRow();


            if (isset($resultado->Resultado)) {
                $mensaje = $resultado->Resultado;

                return [
                    'success' => (strtoupper($mensaje) === 'CORRECTO'),
                    'message' => $mensaje
                ];
            }

            return [
                'success' => false,
                'message' => 'Respuesta inesperada del procedimiento almacenado.'
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ];
        }
    }







}