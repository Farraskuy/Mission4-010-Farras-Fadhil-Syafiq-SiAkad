<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mahasiswa as ModelsMahasiswa;
use CodeIgniter\HTTP\ResponseInterface;

class Mahasiswa extends BaseController
{
    public function __construct(
        protected $mahasiswaModel = new ModelsMahasiswa()
    ) {}

    public function index()
    {
        $search = $this->request->getGet("keyword");

        if ($search) {
            $data = $this->mahasiswaModel->search($search);
        } else {
            $data = $this->mahasiswaModel->getAllMahasiswa();
        }

        return view("Mahasiswa/index", ["mahasiswa" => $data]);
    }

    public function detail($id)
    {
        $mahasiswa = $this->mahasiswaModel->getMahasiswa($id);
        // dd($mahasiswa);
        if (!$mahasiswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Mahasiswa dengan ID $id tidak ditemukan");
        }

        return view('mahasiswa/detail', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function tambah()
    {
        return view("mahasiswa/tambah");
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nim' => [
                'rules'  => 'required|is_unique[biodata.nim]|numeric|min_length[9]|max_length[9]',
                'errors' => [
                    'required'   => 'NIM wajib diisi.',
                    'is_unique'  => 'NIM sudah terdaftar.',
                    'numeric'    => 'NIM hanya boleh angka.',
                    'min_length' => 'NIM harus 9 digit.',
                    'max_length' => 'NIM harus 9 digit.'
                ]
            ],
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                    'max_length' => 'Nama maksimal 100 karakter.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[L,P]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list'  => 'Jenis kelamin hanya boleh L atau P.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput();
        }

        $this->mahasiswaModel->insert([
            'nim'           => $this->request->getPost('nim'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        ]);

        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = $this->mahasiswaModel->getMahasiswa($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Mahasiswa dengan ID $id tidak ditemukan");
        }

        return view('mahasiswa/edit', [
            'mahasiswa' => $data,
        ]);
    }

    public function update($id)
    {
        $rules = [
            'nim' => [
                'rules'  => "required|numeric|min_length[9]|is_unique[biodata.nim,nim,{$id}]|max_length[9]",
                'errors' => [
                    'is_unique'  => 'NIM sudah terdaftar.',
                    'required'   => 'NIM wajib diisi.',
                    'numeric'    => 'NIM hanya boleh angka.',
                    'min_length' => 'NIM harus 9 digit.',
                    'max_length' => 'NIM harus 9 digit.'
                ]
            ],
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                    'max_length' => 'Nama maksimal 100 karakter.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[L,P]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list'  => 'Jenis kelamin hanya boleh L atau P.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->mahasiswaModel->update($id, [
            'nim'           => $this->request->getPost('nim'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        ]);

        return redirect()->to('/mahasiswa')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id)
    {
        $mahasiswa = $this->mahasiswaModel->getMahasiswa($id);

        if (!$mahasiswa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Mahasiswa dengan ID $id tidak ditemukan");
        }

        return view('mahasiswa/hapus', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function destroy($id)
    {
        $this->mahasiswaModel->delete($id);
        return redirect()->to('/mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}
