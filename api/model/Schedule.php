<?php

require_once '../DbHelper.php';
require_once '../utils/constants.php';


define("COL_ID", "id");
define("COL_SEMESTER_START", "semester_start");
define("COL_SEMESTER_END", "semester_end");
define("COL_STUDENT_LIMIT", "student_limit");
define("COL_DAY", "day");
define("COL_SUPERVISOR_ID", "supervisor_id");
define("COL_TIME", "time");

class Schedule
{
    private $dbHelper;
    public $semesterStart;
    public $semesterEnd;
    public $day;
    public $time;
    public $studentLimit;
    public $supervisorId;

   function __construct($db)
   {
       $this->dbHelper = $db;
   }

   function createSchedule() {

   }

   function isDateBetween($start, $end, $date) {
       $newDate = Date(strtotime($date));
       return $newDate >= Date(strtotime($start)) && $newDate <= Date(strtotime($end));
   }

}