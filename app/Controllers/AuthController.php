<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use PHPUnit\Util\Json;

class AuthController extends BaseController
{
    public function login()
    {
        return view("auth/login", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    /**
     * Handle user authentication (login).
     *
     * - Menerima input username/email dan password (POST).
     * - Bisa digunakan baik lewat form biasa maupun AJAX request.
     * - Validasi input username & password.
     * - Periksa apakah user ada di database dan password cocok.
     * - Jika sukses → simpan data user ke session.
     * - Jika gagal → kembalikan response error (AJAX/redirect).
     *
     */
    public function AuthLogin()
    {
        // Tentukan data yang dipakai untuk validasi
        $requestData = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();


        // Ambil input username & password
        $username = $requestData['username'];
        $password = $requestData['password'];

        // Validasi input
        $validation = $this->validateData(
            $requestData,
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                '*.required' => 'Kolom {field} wajib diisi',
            ]
        );

        // Jika validasi gagal (request normal)
        if (!$validation && !$this->request->isAJAX()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        // Jika validasi gagal (AJAX)
        if (!$validation && $this->request->isAJAX()) {
            return response()->setJSON(['validation' => $this->validator->getErrors()]);
        }

        // Cari user berdasarkan username/email
        $usersModel = new Users();
        $user = $usersModel
            ->where('username', $username)
            ->orWhere('email', $username)
            ->join('students', 'students.user_id = users.id', 'left')
            ->first();

        // Validasi password
        if (!$user || !password_verify($password, $user['password'])) {
            $errorMessage = ['error' => 'Username/Email atau password salah'];

            // Response AJAX
            if ($this->request->isAJAX()) {
                return response()->setJSON($errorMessage);
            }

            // Response redirect
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $errorMessage['error']);
        }

        // Simpan data user ke session
        session()->set('users', $user);

        // Redirect ke halaman utama
        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success' => true,
                'message' => 'Successfully Login',
                'redirect_to' => base_url()
            ]);
        }
        return redirect()->to('/');
    }


    public function Register() {}

    public function AuthRegister() {}

    /**
     * logout
     * menghancurkan session login user
     * mengembalikan ke halaman login
     */
    public function logout()
    {
        session()->remove('users');

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success' => true,
                'message' => 'Succesfully logout',
                'redirect_to' => base_url()
            ]);
        }
        return redirect()->to('login');
    }
}
