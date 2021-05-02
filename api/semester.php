<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'DbHelper.php';
include_once 'controller/SemesterController.php';

error_reporting(E_ALL ^ E_WARNING);

$db = new DbHelper(SEMESTER_TABLE_NAME);
$semesterController = new SemesterController($db);
$data = json_decode(file_get_contents("php://input"));

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $id = $_GET['id'];
        $name = $_GET['name'];
        if (isset($id)) {
            echo $semesterController->getSemesterById($id);
        } elseif (isset($name)) {
            echo $semesterController->getSemesterByName($name);
        } else {
            echo $semesterController->getSemesters();
        }
        break;
    case "POST":
        if (isset($data)) {
            echo $semesterController->createSemester($data);
        } else {
            echo error("Data is empty");
        }
        break;
    case "DELETE":
        $id = $_GET['id'];
        if (isset($id)) {
            echo $semesterController->deleteSemester($id);
        } else {
            echo error("No id provided");
        }

}
