<?php
    class Student
    {
        private $name;
        private $date_enrolled;
        private $id;

        function __construct($name, $date_enrolled, $id = null)
        {
            $this->name = $name;
            $this->date_enrolled = $date_enrolled;
            $this->id = $id;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getName()
        {
            return $this->name;
        }

        function setDateEnrolled($date_enrolled)
        {
            $this->date_enrolled = $date_enrolled;
        }

        function getDateEnrolled()
        {
            return $this->date_enrolled;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, date_enrolled) VALUES ('{$this->getName()}', '{$this->getDateEnrolled()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $date_enrolled = $student['date_enrolled'];
                $id = $student['id'];
                $new_student = new Student($name, $date_enrolled, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        static function findStudent($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach ($students as $student) {
                $id = $student->getId();
                if ($id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        function updateStudent($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getId()};");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id) VALUES ({$course->getId()}, {$this->getId()});");
        }

        function getCourse()
        {
            $courses = $GLOBALS['DB']->query("SELECT courses.* FROM students JOIN students_courses ON (students.id = students_courses.student_id) JOIN courses ON (students_courses.course_id = courses.id) WHERE students.id = {$this->getId()};");

            $returned_courses = array();
            foreach($courses as $course) {
                $name = $course['name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($name, $course_number, $id);
                array_push($returned_courses, $new_course);
            }
            return $returned_courses;
        }
    }





?>
