<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class AuthController extends BaseController
{
    public function login()
    {
        return view("auth/login", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function AuthLogin()
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        if (!$this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            '*.required' => 'Kolom {field} wajib diisi'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $users = new Users();
        $users = $users->where('username', $username)->orWhere('email', $username)
            ->join('students', 'students.user_id = users.id', 'left')
            ->first();

        if (!$users || !password_verify($password, $users['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username/Email atau password salah');
        }

        session()->set('users', $users);

        return redirect()->to('/');
    }

    public function Register() {}

    public function AuthRegister() {}

    public function logout()
    {
        session()->remove('users');

        return redirect()->to('login');
    }
}
