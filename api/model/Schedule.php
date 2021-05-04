<?php

require_once '../DbHelper.php';
require_once '../utils/constants.php';

class Schedule
{
    private DbHelper $db;
    public $semesterId;
    public $id;
    public $day;
    public $time;
    public $studentLimit;
    public $supervisorId;

   function __construct($db)
   {
       $this->db = $db;
   }

   function createSchedule() {
        return $this->db->insert(SCHEDULE_TABLE_NAME,
            array(
                COL_SEMESTER_ID => $this->semesterId,
                COL_DAY => $this->day,
                COL_TIME => $this->time,
                COL_STUDENT_LIMIT => $this->studentLimit,
                COL_SUPERVISOR_ID => $this->supervisorId
            ),
            array(COL_SEMESTER_ID, COL_DAY, COL_TIME, COL_STUDENT_LIMIT, COL_SUPERVISOR_ID)
        );
   }

   function getSchedules() {
       return $this->db->select(SCHEDULE_TABLE_NAME, array(COL_SUPERVISOR_ID => $this->supervisorId))[RESPONSE_DATA];
   }

    function getSchedule() {
        return $this->db->select(SCHEDULE_TABLE_NAME, array(COL_ID => $this->id, COL_SUPERVISOR_ID => $this->supervisorId))[RESPONSE_DATA];
    }

   function updateSchedule() {
       return $this->db->update(SCHEDULE_TABLE_NAME,
           array(
           COL_SEMESTER_ID => $this->semesterId,
           COL_DAY => $this->day,
           COL_TIME => $this->time,
           COL_STUDENT_LIMIT => $this->studentLimit),

           array(COL_ID => $this->id),
           array(COL_SEMESTER_ID, COL_DAY, COL_TIME, COL_STUDENT_LIMIT));
   }

   function deleteSchedule() {
       return $this->db->delete(SCHEDULE_TABLE_NAME, array(COL_SUPERVISOR_ID => $this->supervisorId,
           COL_ID => $this->id));
   }

   function isOwner() {
       return $this->db->select(SCHEDULE_TABLE_NAME,
               array(COL_ID => $this->id, COL_SUPERVISOR_ID => $this->supervisorId))[RESPONSE_STATUS] == DbResponse::STATUS_SUCCESS;
   }

}