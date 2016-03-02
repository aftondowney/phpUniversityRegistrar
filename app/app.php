<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();

    $app['debug']= true;

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/courses", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $new_course = new Course($name, $course_number);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/course/{id}/edit", function($id) use ($app) {
        $course = Course::findCourse($id);
        return $app['twig']->render('course_edit.html.twig', array('course' => $course));
    });

    $app->delete("/course/{id}/delete", function($id) use ($app) {
        $course = Course::findCourse($id);
        $course->deleteCourse();
        return $app['twig']->render('courses.html.twig', array('course' => $course, 'courses' => Course::getAll()));
    });

    $app->patch("/course/{id}", function($id) use ($app) {
        $new_name = $_POST['name'];
        $course = Course::findCourse($id);
        $course->updateCourse($new_name);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => Student::getAll()));
    });

    $app->get("/course/{id}", function($id) use ($app) {
        $course = Course::findCourse($id);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => Student::getAll()));
    });

    $app->post("/students", function() use ($app) {
        $name = $_POST['name'];
        $date_enrolled = $_POST['date_enrolled'];
        $new_student = new Student($name, $date_enrolled);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/student/{id}/edit", function($id) use ($app) {
        $student = Student::findStudent($id);
        return $app['twig']->render('student_edit.html.twig', array('student' => $student));
    });

    $app->patch("/student/{id}", function($id) use ($app) {
        $new_name = $_POST['name'];
        $student = Student::findStudent($id);
        $student->updateStudent($new_name);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'students' => Student::getAll(), 'courses' => $student->getCourse()));
    });

    $app->get("/student/{id}", function($id) use ($app) {
        $student = Student::findStudent($id);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'students' => Student::getAll(), 'courses' => $student->getCourse()));
    });

    return $app;





















?>
