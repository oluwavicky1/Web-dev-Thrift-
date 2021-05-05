<?php
include_once '../utils/helpers.php';
include_once '../utils/constants.php';
include_once '../model/Schedule.php';
include_once '../model/User.php';
include_once '../model/Semester.php';
include_once '../model/Message.php';
include_once '../model/Appointment.php';
include_once '../model/AppointmentStatus.php';

class AppointmentController
{
    private Schedule $schedule;
    private User $user;
    private Semester $semester;
    private Message $message;
    private Appointment $appointment;

    function __construct()
    {
        $db = new DbHelper();
        $this->schedule = new Schedule($db);
        $this->user = new User($db);
        $this->semester = new Semester($db);
        $this->message = new Message($db);
        $this->appointment = new Appointment($db);
    }

    function createAppointment($appointment) {
        $this->appointment->userId = $appointment->userId;
        $this->appointment->scheduleId = $appointment->scheduleId;
        $response = $this->appointment->addAppointment();
        if ($response[RESPONSE_STATUS] == DbResponse::STATUS_SUCCESS) {
            $this->sendMessage($this->appointment->scheduleId, $this->appointment->userId);
            return success("Appointment created successfully", null);
        }
        return error($response[RESPONSE_MESSAGE]);
    }

    function cancelAppointment($appointment) {
        $this->appointment->id = $appointment->id;
    }

    private function sendMessage($scheduleId, $userId) {
        $this->schedule->id = $scheduleId;
        $schedule = $this->schedule->getSchedule();
        $content = $schedule[COL_MESSAGE];
        $this->message->scheduleId = $scheduleId;
        $this->message->senderId = $schedule[COL_SUPERVISOR_ID];
        $this->message->receiverId = $userId;
        $this->message->content = $content;
        $this->message->addMessage();
    }

}