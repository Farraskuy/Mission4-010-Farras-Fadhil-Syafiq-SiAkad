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
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet("keyword");

            $coursesModel = new Courses();

            if ($search && $search != '') {
                $courses = $coursesModel
                    ->like('course_name', $search)
                    ->findAll();
            } else {
                $courses = $coursesModel->findAll();
            }

            return response()->setJSON([
                'data' => $courses
            ]);
        }

        return view("Course/index");
    }

    public function student()
    {
        $userId = session()->get('users')['id'];

        $coursesModel = new Courses();
        $studentModel = new Students();
        $takesModel   = new Takes();

        // Cari student dari user login
        $student = $studentModel->where('user_id', $userId)->first();

        // Kalau AJAX: return JSON
        if ($this->request->isAJAX()) {
            $takenIds = [];
            $takenCourses = [];

            if ($student) {
                // Ambil course yang sudah diambil
                $takes = $takesModel
                    ->select('courses.*')
                    ->join('courses', 'courses.id = takes.course_id')
                    ->where('student_id', $student['nim'])
                    ->findAll();

                $takenCourses = $takes;
                $takenIds     = array_column($takes, 'id');
            }

            // Ambil course yang belum diambil
            if (!empty($takenIds)) {
                $availableCourses = $coursesModel
                    ->whereNotIn('id', $takenIds)
                    ->findAll();
            } else {
                $availableCourses = $coursesModel->findAll();
            }

            return $this->response->setJSON([
                'available' => $availableCourses,
                'taken'     => $takenCourses
            ]);
        }

        // Kalau bukan AJAX: tampilkan view student enrollment
        return view('Course/student');
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
        $data = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();

        $validation = $this->validateData($data, [
            'course_name' => 'required|min_length[3]|max_length[255]',
            'credits'     => 'required|numeric'
        ]);

        if (!$validation) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success'    => false,
                    'validation' => $this->validator->getErrors()
                ]);
            }

            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator->getErrors());
        }

        $courseModel = new Courses();
        $courseModel->insert([
            'course_name' => $data['course_name'],
            'credits'     => $data['credits'],
        ]);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'     => true,
                'message'     => 'Course created!',
                'redirect_to' => base_url('course')
            ]);
        }

        return redirect()->to('/course')->with('success', 'Course created!');
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
        $courseModel = new Courses();
        $course      = $courseModel->find($id);

        if (!$course) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success' => false,
                    'error'   => 'Course not found'
                ]);
            }
            return redirect()->back()->with('error', 'Course not found');
        }

        $data = $this->request->isAJAX()
            ? json_decode($this->request->getBody(), true)
            : $this->request->getPost();

        $validation = $this->validateData($data, [
            'course_name' => 'required|min_length[3]|max_length[255]',
            'credits'     => 'required|numeric'
        ]);

        if (!$validation) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success'    => false,
                    'validation' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $courseModel->update($id, [
            'course_name' => $data['course_name'],
            'credits'     => $data['credits'],
        ]);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'     => true,
                'message'     => 'Course updated!',
                'redirect_to' => base_url('course')
            ]);
        }

        return redirect()->to('/course')->with('success', 'Course updated!');
    }
    
    public function enroll()
    {
        $userId = session()->get('users')['id'];
        $student = (new Students())->where('user_id', $userId)->first();

        if (!$student) {
            return $this->response->setJSON(['success' => false, 'message' => 'Student not found']);
        }

        // Ambil data JSON atau POST
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        $courseIds = $data['course_ids'] ?? null;

        if (!$courseIds || !is_array($courseIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No courses selected']);
        }

        $takes = new Takes();
        foreach ($courseIds as $courseId) {
            $exists = $takes->where('course_id', $courseId)
                ->where('student_id', $student['nim'])
                ->first();
            if (!$exists) {
                $takes->insert([
                    'course_id'   => $courseId,
                    'student_id'  => $student['nim'],
                    'enroll_date' => Time::now()
                ]);
            }
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Enrolled successfully']);
    }

    public function unenroll()
    {
        $userId = session()->get('users')['id'];
        $student = (new Students())->where('user_id', $userId)->first();

        if (!$student) {
            return $this->response->setJSON(['success' => false, 'message' => 'Student not found']);
        }

        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        $courseIds = $data['course_ids'] ?? null;

        if (!$courseIds || !is_array($courseIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No courses selected']);
        }

        $takes = new Takes();
        foreach ($courseIds as $courseId) {
            $takes->where('course_id', $courseId)
                ->where('student_id', $student['nim'])
                ->delete();
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Un-Enrolled successfully']);
    }



    public function destroy($id)
    {
        $courseModel = new Courses();
        $course      = $courseModel->find($id);

        if (!$course) {
            if ($this->request->isAJAX()) {
                return response()->setJSON([
                    'success' => false,
                    'error'   => "Course with ID $id not found"
                ]);
            }
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course with ID $id not found");
        }

        $courseModel->delete($id);

        if ($this->request->isAJAX()) {
            return response()->setJSON([
                'success'    => true,
                'message'    => 'Course deleted!',
                'closeModal' => true
            ]);
        }

        return redirect()->to('/course')->with('success', 'Course deleted!');
    }
}
