<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Courses;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;

class CourseController extends BaseController
{
    public function index()
    {
        $search = $this->request->getGet("keyword");
        $courses = new Courses();

        $courses = $courses->like('course_name', $search ?? '')->findAll();

        return view("Course/index", ["courses" => $courses]);
    }


    public function detail($id)
    {
        $courses = new Courses();
        $data = $courses->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course with ID $id not found");
        }

        return view('course/detail', [
            'course' => $data,
        ]);
    }


    public function tambah()
    {
        return view("course/tambah", [
            'validation' => session()->getFlashdata('validation')
        ]);
    }

    public function store()
    {
        $rules = [
            'course_name' => 'required|min_length[3]|max_length[255]',
            'credits' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()->with('validation', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        $user = new Courses();
        $user = $user->insert([
            'course_name' => $data['course_name'],
            'credits' => $data['credits'],
        ]);

        return redirect()->to('/course')->with('success', 'Course created.');
    }

    public function edit($id)
    {
        $courses = new Courses();
        $data = $courses->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course with ID $id not found");
        }

        return view('course/edit', [
            'validation' => session()->getFlashdata('validation'),
            'course' => $data,
        ]);
    }

    public function update($id)
    {
        $course = new Courses();
        $course = $course->find($id);

        if (!$course) {
            return redirect()->back()->with('error', 'Course is not fount');
        }

        $rules = [
            'course_name' => 'required|min_length[3]|max_length[255]',
            'credits' => 'required|numeric'
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = $this->request->getPost();

        $user = new Courses();
        $user = $user->update($id, [
            'course_name' => $data['course_name'],
            'credits' => $data['credits'],
        ]);

        return redirect()->to('/course')->with('success', 'Course updated!');
    }

    public function destroy($id)
    {
        $courses = new Courses();
        $data =  $courses->find($id);

        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course with ID $id not found");
        }

        $courses->delete($id);
        return redirect()->to('/course')->with('success', 'Course deleted!');
    }
}
