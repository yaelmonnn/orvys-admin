<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodoModel extends Model
{
    protected $table = 'periodos';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'periodo',
        'fecha_inicio', 
        'fecha_fin', 
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

    public function insertarPeriodo($data)
    {
        $db = \Config\Database::connect();
        
        $periodo = $data['periodo'];
        $fecha_inicio = $data['fecha_inicio'];
        $fecha_fin = $data['fecha_fin'];
        $estatus = $data['estatus'];
        
        try {
            $sql = "EXEC pa_Insertar_Periodo ?, ?, ?, ?";
            $query = $db->query($sql, [$periodo, $fecha_inicio, $fecha_fin, $estatus]);
            
            if (!$query) {
                return false;
            }
            
            $result = $query->getResultArray();
        
            if (empty($result)) {
                return false;
            }
            
            if (!isset($result[0]['Result'])) {
                return false;
            }
            
            $resultValue = trim($result[0]['Result']);
        
            if ($resultValue === 'CORRECTO') {
                return true;
            } else {
                return ['error' => $resultValue];
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Exception en insertarPeriodo: ' . $e->getMessage());
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



}