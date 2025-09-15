<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Students;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function index()
    {
        $search = $this->request->getGet("keyword");
        $students = new Students();

        $students = $students->join('users', 'users.id = students.user_id');

        if ($search) {
            $students = $students->like('username', $search)->orLike('nim',  $search)->findAll();
        } else {
            $students = $students->findAll();
        }

        return view("Student/index", ["students" => $students]);
    }


    public function detail($id)
    {
        $students = new Students();
        $data = $students->join('users', 'users.id = students.user_id')->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Student dengan ID $id tidak ditemukan");
        }

        return view('student/detail', [
            'student' => $data,
        ]);
    }


    public function tambah()
    {
        return view("student/tambah", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function store()
    {
        $rules = [
            'nim' => 'required|is_unique[students.nim]|numeric|min_length[9]|max_length[9]',
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email',
            'password' => 'required|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()->with('validation', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $user = new Users();
        $user = $user->insert([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password ' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'student'
        ]);

        $userUpdate = new Users();
        $userUpdate = $userUpdate->update($user, [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        $students = new Students();
        $students->insert([
            'user_id' => $user,
            'nim' => $data['nim'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'entry_year' => date_parse($data['entry_year'])['year'],
        ]);

        return redirect()->to('/student')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $students = new Students();
        $data = $students->join('users', 'users.id = students.user_id')->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Student dengan ID $id tidak ditemukan");
        }

        return view('student/edit', [
            'validation' => session()->getFlashdata('validation'),
            'student' => $data,
        ]);
    }

    public function update($id)
    {
        $student = new Students();
        $student = $student->find($id);

        if (!$student) {
            return redirect()->back()->with('error', 'Student is not fount');
        }

        $rules = [
            'nim' => "required|is_unique[students.nim,id,$id]|numeric|min_length[9]|max_length[9]",
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username' => "required|is_unique[users.username,id,{$student['user_id']}]",
            'email' => 'required|valid_email',
            'password' => 'required|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/]'
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = $this->request->getPost();

        $user = new Users();
        $user = $user->update($student['user_id'], [
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'role' => 'student'
        ]);

        $students = new Students();
        $students->update($student['id'], [
            'user_id' => $user,
            'nim' => $data['nim'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'entry_year' => date_parse($data['entry_year'])['year'],
        ]);

        return redirect()->to('/students')->with('success', 'Data berhasil diupdate!');
    }


    public function edit_password($id)
    {
        $students = new Students();
        $data = $students->join('users', 'users.id = students.user_id')->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Student dengan ID $id tidak ditemukan");
        }

        return view('student/update-password', [
            'validation' => session()->getFlashdata('validation'),
            'student' => $data,
        ]);
    }

    public function update_password($id)
    {
        $student = new Students();
        $student = $student->find($id);

        if (!$student) {
            return redirect()->back()->with('error', 'Student is not fount');
        }

        $rules = [
            'password' => 'required|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/]',
            'repeat-password' => 'required|matches[password]|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/]'
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = $this->request->getPost();

        $user = new Users();
        $user = $user->update($student['user_id'], [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/student')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $students = new Students();
        $data =  $students->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Student with ID $id not found");
        }

        $students->delete($id);
        return redirect()->to('/student')->with('success', 'Data students berhasil dihapus!');
    }
}
