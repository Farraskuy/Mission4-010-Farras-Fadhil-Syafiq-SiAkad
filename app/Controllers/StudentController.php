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
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet("keyword");

            $students = new Students();

            $students = $students->join('users', 'users.id = students.user_id');

            if ($search && $search != '') {
                $students = $students->like('username', "%$search%")->orLike('nim',  "%$search%")->findAll();
            } else {
                $students = $students->findAll();
            }

            return response()->setJSON([
                'data' => $students
            ]);
        }

        return view("Student/index");
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
        $data = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();

        $rules = [
            'nim'       => 'required|is_unique[students.nim]|numeric|min_length[9]|max_length[9]',
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username'  => 'required|is_unique[users.username]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|regex_match[/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/]'
        ];

        if (!$this->validateData($data, $rules)) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success'    => false,
                    'validation' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel = new Users();
        $userId = $userModel->insert([
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'      => 'student'
        ]);

        $studentModel = new Students();
        $studentModel->insert([
            'user_id'       => $userId,
            'nim'           => $data['nim'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'entry_year'    => date_parse($data['entry_year'])['year'],
        ]);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'     => true,
                'message'     => 'Student created!',
                'redirect_to' => base_url('student')
            ]);
        }

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
        
        $studentModel = new Students();
        $student      = $studentModel->find($id);

        if (!$student) {
            if ($this->request->isAJAX()) {
                return response()->setJSON(['success' => false, 'error' => 'Student not found']);
            }
            return redirect()->back()->with('error', 'Student not found');
        }

        $data = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();

        $rules = [
            'nim'       => "required|is_unique[students.nim,nim,{$student['nim']}]|numeric|min_length[9]|max_length[9]",
            'full_name' => 'required|min_length[3]|max_length[255]',
            'username'  => "required|is_unique[users.username,id,{$student['user_id']}]",
            'email'     => "required|valid_email|is_unique[users.email,id,{$student['user_id']}]",
        ];

        if (!$this->validateData($data, $rules)) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success'    => false,
                    'validation' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $userModel = new Users();
        $userModel->update($student['user_id'], [
            'username'  => $data['username'],
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'role'      => 'student'
        ]);

        $studentModel->update($id, [
            'nim'           => $data['nim'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'entry_year'    => date_parse($data['entry_year'])['year'],
        ]);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'     => true,
                'message'     => 'Student updated!',
                'redirect_to' => base_url('student')
            ]);
        }

        return redirect()->to('/student')->with('success', 'Data berhasil diupdate!');
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
        $studentModel = new Students();
        $student      = $studentModel->find($id);

        if (!$student) {
            if ($this->request->isAJAX()) {
                return response()->setJSON(['success' => false, 'error' => 'Student not found']);
            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Student with ID $id not found");
        }

        $userModel = new Users();
        $userModel->delete($student['user_id']);
        $studentModel->delete($id);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'    => true,
                'message'    => 'Student deleted!',
                'closeModal' => true
            ]);
        }

        return redirect()->to('/student')->with('success', 'Data students berhasil dihapus!');
    }
}
