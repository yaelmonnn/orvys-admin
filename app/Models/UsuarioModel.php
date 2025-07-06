<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nombre',
        'telefono', 
        'email', 
        'password',
        'created_at',
        'updated_at'
    ];


    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';


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


    public function traerUsuarios() {
        try {
            $db = \Config\Database::connect();
            $sql = "EXEC pa_Traer_Usuarios";
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


    public function insertarUsuario($datos)
    {
        try {
            $db = \Config\Database::connect();
            
            $nombre = $datos['nombre'];
            $telefono = $datos['telefono'];
            $email = $datos['email'];
            $password = $datos['password'];
            
            
            $sql = "EXEC pa_Insertar_Usuario ?, ?, ?, ?";
            $result = $db->query($sql, [$nombre, $telefono, $email, $password]);
            
            if ($result) {
                $row = $result->getRow();
                
                if ($row) {
                    if (isset($row->status) && $row->status === 'success') {
                        if (isset($row->id) && $row->id > 0) {
                            return $row->id;
                        }
                        
                        $usuario = $this->where('email', $email)->first();
                        if ($usuario) {
                            return $usuario['Id'];
                        }
                    } else {
                        $errorMessage = $row->message ?? 'Error desconocido';
                        throw new \Exception($errorMessage);
                    }
                }
            }
            
            return false;
            
        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            
            if (strpos(strtolower($errorMessage), 'email') !== false && 
                (strpos(strtolower($errorMessage), 'registrado') !== false || 
                 strpos(strtolower($errorMessage), 'duplicate') !== false || 
                 strpos(strtolower($errorMessage), 'unique') !== false)) {
                throw new \Exception('El email ya está registrado');
            }
            
            if (strpos(strtolower($errorMessage), 'syntax') !== false) {
                throw new \Exception('Error en la sintaxis del procedimiento almacenado');
            }
            
            if (strpos($errorMessage, 'Usuario') !== false || 
                strpos($errorMessage, 'email') !== false ||
                strpos($errorMessage, 'teléfono') !== false ||
                strpos($errorMessage, 'contraseña') !== false) {
                throw new \Exception($errorMessage);
            }
            
            throw new \Exception('Error al registrar el usuario');
        }
    }

    public function validarCredenciales($email)
    {
        $db = \Config\Database::connect();

        $sql = "EXEC pa_ValidarLogin @Email = ?";
        $query = $db->query($sql, [$email]);

        return $query->getRowArray();
    }

    public function traerRol($email) {
        $db = \Config\Database::connect();
        $sql = "EXEC pa_Traer_Rol @email = ?";
        $query = $db->query($sql, [$email]);
        return $query->getRowArray();
    }




    public function obtenerPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function traerGruposPorUsuario($usuarioId)
    {
        $db = \Config\Database::connect();
        $sql = "EXEC pa_Grupos_Usuarios ?";
        $query = $db->query($sql, [$usuarioId]);
        
        if ($query) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function eliminarUsuario($id)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("EXEC pa_Eliminar_Usuario ?", [$id]);
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


    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    public function actualizarUsuario($id, $datos)
    {
        try {
            return $this->update($id, $datos);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar usuario: ' . $e->getMessage());
            return false;
        }
    }

    public function existeEmail($email, $excluirId = null)
    {
        $builder = $this->where('email', $email);
        
        if ($excluirId) {
            $builder->where('Id !=', $excluirId);
        }
        
        return $builder->countAllResults() > 0;
    }

    public function obtenerUsuarios($limite = 10, $offset = 0)
    {
        return $this->select('Id, nombre, telefono, email, created_at')
                    ->limit($limite, $offset)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function contarUsuarios()
    {
        return $this->countAllResults();
    }
}