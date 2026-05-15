<?php

require_once '../app/models/StudentModel.php';

class student
{
    public function index()
    {
        $studentModel = new StudentModel();

        $students = $studentModel->getStudents();

        require_once '../app/views/student/index.php';
    }
}
?>