<?php
require_once '../DbHelper.php';
require_once '../utils/constants.php';
require_once 'AppointmentStatus.php';

class Appointment
{
    private DbHelper $db;
    public $id;
    public $scheduleId;
    public $userId;
    public $status;
    public $date;

    function __construct($db)
    {
        $this->db = $db;
    }

    function addAppointment() {
        return $this->db->insert(APPOINTMENT_TABLE_NAME, array(
            COL_SCHEDULE_ID => $this->scheduleId,
            COL_USER_ID => $this->userId,
            COL_STATUS => AppointmentStatus::pending
        ), array(COL_SCHEDULE_ID, COL_USER_ID, COL_STATUS));
    }

    function updateAppointment() {
        return $this->db->update(APPOINTMENT_TABLE_NAME,
            array(COL_STATUS => $this->status),
            array(COL_ID => $this->id),
            array(COL_STATUS => $this->status));
    }

    function getAppointmentById() {
        return $this->db->select(APPOINTMENT_TABLE_NAME, array(COL_ID => $this->id))[RESPONSE_DATA];
    }

    function getAppointmentBySchedule() {
        return $this->db->select(APPOINTMENT_TABLE_NAME, array(COL_SCHEDULE_ID => $this->scheduleId))[RESPONSE_DATA];
    }

    function getAppointmentByUser() {
        return $this->db->select(APPOINTMENT_TABLE_NAME, array(COL_USER_ID => $this->userId))[RESPONSE_DATA];
    }
}