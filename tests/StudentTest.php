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

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "Tubbs";
            $date_enrolled = "2016-03-01";
            $id = null;
            $test_student = new Student($name, $date_enrolled, $id);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Tubbs";
            $date_enrolled = "2016-03-01";
            $id = 4;
            $test_student = new Student($name, $date_enrolled, $id);
            $test_student->save();

            $name2 = "Joe DiMeowgio";
            $date_enrolled2 = "2016-02-29";
            $id2 = 6;
            $test_student2 = new Student($name2, $date_enrolled2, $id2);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Tubbs";
            $date_enrolled = "2016-03-01";
            $id = 3;
            $test_student = new Student($name, $date_enrolled, $id);
            $test_student->save();

            $name2 = "Joe DiMeowgio";
            $date_enrolled2 = "2016-02-29";
            $id2 = 2;
            $test_student2 = new Student($name2, $date_enrolled2, $id2);
            $test_student2->save();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testFindStudent()
        {
            //Arrange
            $name = "Tubbs";
            $date_enrolled = "2016-03-01";
            $id = 3;
            $test_student = new Student($name, $date_enrolled, $id);
            $test_student->save();

            $name2 = "Joe DiMeowgio";
            $date_enrolled2 = "2016-02-29";
            $id2 = 2;
            $test_student2 = new Student($name2, $date_enrolled2, $id2);
            $test_student2->save();

            //Act
            $result = Student::findStudent($test_student2->getId());

            //Assert
            $this->assertEquals($test_student2, $result);
        }

}






?>
