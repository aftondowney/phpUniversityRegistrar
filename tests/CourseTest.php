<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "History";
            $course_number = 101;
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Econ";
            $course_number = 200;
            $id = 2;

            $name2 = "Physics";
            $course_number2 = 401;
            $id2 = 3;

            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Econ";
            $course_number = 200;
            $id = 2;

            $name2 = "Physics";
            $course_number2 = 401;
            $id2 = 3;

            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            Course::deleteAll();

            //Assert
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateCourse()
        {
            //Arrange
            $name = "Econ";
            $course_number = 200;
            $id = 2;

            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $new_name = "Economics";

            //Act
            $test_course->updateCourse($new_name);

            //Assert
            $this->assertEquals("Economics", $test_course->getName());
        }

        function testDeleteCourse()
        {
            //Arrange
            $name = "Econ";
            $course_number = 200;
            $id = 2;

            $name2 = "Physics";
            $course_number2 = 401;
            $id2 = 3;

            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $test_course->deleteCourse();

            //Assert
            $this->assertEquals([$test_course2], Course::getAll());
        }

        function testFindCourse()
        {
            //Arrange
            $name = "Econ";
            $course_number = 200;
            $id = 2;

            $name2 = "Physics";
            $course_number2 = 401;
            $id2 = 3;

            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::findCourse($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        function testAddStudent()
        {
            $name = "History";
            $course_number = 101;
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name = "Tubbs";
            $date_enrolled = "2016-03-01";
            $id = 3;
            $test_student = new Student($name, $date_enrolled, $id);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals([$test_student], $test_course->getStudent());
        }

        function testGetStudent()
        {
          //Arrange
          $name = "History";
          $course_number = 101;
          $id = 1;
          $test_course = new Course($name, $course_number, $id);
          $test_course->save();

          $name = "Tubbs";
          $date_enrolled = "2016-03-01";
          $id = 3;
          $test_student = new Student($name, $date_enrolled, $id);
          $test_student->save();

          $name2 = "Willie";
          $date_enrolled2 = "2016-06-23";
          $id2 = 3;
          $test_student2 = new Student($name, $date_enrolled2, $id2);
          $test_student2->save();

          //Act
          $test_course->addStudent($test_student);
          $test_course->addStudent($test_student2);

          //Assert
          $this->assertEquals($test_course->getStudent(), [$test_student, $test_student2]);
        }

    }

















?>
