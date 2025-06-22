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
}