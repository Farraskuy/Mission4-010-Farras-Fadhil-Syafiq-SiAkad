<?php

namespace App\Models;

use CodeIgniter\Model;

class Mahasiswa extends Model
{
    protected $table            = 'biodata';
    protected $primaryKey       = 'nim';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['nim', 'nama_lengkap', 'jenis_kelamin'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function search($keyword) {
        return $this->db->query("SELECT * FROM BIODATA WHERE NIM LIKE '%$keyword%' OR NAMA_LENGKAP LIKE '%$keyword%'")->getResultArray();
    }

    public function getAllMahasiswa()
    {
        return $this->db->query("SELECT * FROM BIODATA")->getResultArray();
    }

    public function getMahasiswa($nim)
    {
        return $this->db->query("SELECT * FROM BIODATA WHERE NIM = '$nim'")->getRowArray();
    }

    public function updateMahasiswa($nim, $nama_lengkap, $jenis_kelamin)
    {
        $query = $this->db->query("SELECT * FROM BIODATA WHERE NIM = '$nim'")->getResultArray();
        if (!$query) {
            $nim = $nim ? $nim : $query['nim'];
            $nama_lengkap = $nama_lengkap ? $nama_lengkap : $query['nama_lengkap'];
            $jenis_kelamin = $jenis_kelamin ? $jenis_kelamin : $query['jenis_kelamin'];
            $query2 = $this->db->query("UPDATE BIODATA SET nim='$nim', nama_lengkap='$nama_lengkap', jenis_kelamin='$jenis_kelamin'");
            if ($query2) {
                return true;
            }
        }
        return false;
    }

    public function deleteMahasiswa($nim)
    {
        $query = $this->db->query("SELECT * FROM BIODATA WHERE NIM = '$nim'")->getResultArray();
        if (!$query) {
            $query2 = $this->db->query("DELETE FROM BIODATA WHERE NIM='$nim'");
            if ($query2) {
                return true;
            }
        }
        return false;
    }
}
