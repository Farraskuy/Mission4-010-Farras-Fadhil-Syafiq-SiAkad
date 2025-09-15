<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Courses;
use App\Models\Students;
use App\Models\Takes;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class CourseController extends BaseController
{
    public function index()
    {
        $search = $this->request->getGet("keyword");

        $userId = session()->get('users')['id'];

        $coursesModel = new Courses();
        $studentModel = new Students();
        $takeModel    = new Takes();

        $student = $studentModel->where('user_id', $userId)->first();

        $takenCourses = [];
        if ($student) {
            $takes = $takeModel
                ->select('course_id')
                ->where('student_id', $student['nim'])
                ->findAll();

            $takenCourses = array_column($takes, 'course_id');
        }

        $courses = $coursesModel
            ->like('course_name', $search ?? '')
            ->findAll();

        return view("Course/index", [
            "courses"      => $courses,
            "takenCourses" => $takenCourses
        ]);
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

    public function enroll($courseId)
    {
        $userId = session()->get('users')['id'];
        $student = new Students();
        $student = $student->where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }

        $takes = new Takes();
        $takes->insert([
            'course_id' => $courseId,
            'student_id' => $student['nim'],
            'enroll_date' => Time::now()
        ]);

        return redirect()->back()->with('success', 'Enrolled successfully');
    }

    public function unenroll($courseId)
    {
        $userId = session()->get('users')['id'];
        $student = new Students();
        $student = $student->where('user_id', $userId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }

        $takes = new Takes();
        $takes->where('course_id', $courseId)
            ->where('student_id', $student['nim'])
            ->delete();

        return redirect()->back()->with('success', 'Un-Enrolled successfully');
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
