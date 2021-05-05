<?php
include_once '../utils/helpers.php';
include_once '../utils/constants.php';
include_once '../model/Schedule.php';
include_once '../model/User.php';
include_once '../model/Semester.php';
include_once '../model/Message.php';
include_once '../model/Appointment.php';


class ScheduleController
{
    private Schedule $schedule;
    private User $user;
    private Semester $semester;
    private  Message $message;
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

    function createSchedule($schedule) {
        $this->user->id = $schedule->supervisorId;
        if ($this->user->isSupervisor()) {
            $this->schedule->studentLimit = $schedule->studentLimit;
            $this->schedule->timeStart = $schedule->timeStart;
            $this->schedule->timeEnd = $schedule->timeEnd;
            $this->schedule->day = $schedule->day;
            $this->schedule->supervisorId = $schedule->supervisorId;
            $this->schedule->message = $schedule->message;
            $this->schedule->semesterId = $schedule->semesterId;
            $this->schedule->name = $schedule->name;
            return success("Schedule created successfully", $this->schedule->createSchedule());
        }
        return unauthorized("User id ". $schedule->supervisorId . " is not a supervisor");
    }

    function getSchedules($supervisorId) {
        $this->user->id = $supervisorId;
        if ($this->user->isSupervisor()) {
            $this->schedule->supervisorId = $supervisorId;
            return success("Schedules requested", $this->schedule->getSchedules());
        }
        return unauthorized("User id ". $supervisorId . " is not a supervisor");
    }

    function getSchedule($id, $supervisorId) {
        $this->user->id = $supervisorId;
        if ($this->user->isSupervisor()) {
            $this->schedule->id = $id;
            $this->schedule->supervisorId = $supervisorId;
            return success("Schedules requested", $this->schedule->getSchedules());
        }
        return error("User id ". $supervisorId . " is not a supervisor");
    }

    function updateSchedule($schedule) {
        $this->user->id = $schedule->supervisorId;
        $this->schedule->id = $schedule->id;
        $this->schedule->supervisorId = $schedule->supervisorId;
        $this->schedule->status = $schedule->status;
        if ($this->user->isSupervisor() && $this->schedule->isOwner()) {
            $this->schedule->updateSchedule();
            if (!$this->schedule->status) {
                $this->sendMessage($schedule->message);
            }
            return success("Schedule updated successfully", null);
        }
        return unauthorized("User id ". $schedule->supervisorId . " is not a supervisor or does not have access to schedule");
    }

    function deleteSchedule($id, $supervisorId) {
        $this->schedule->id = $id;
        $this->schedule->supervisorId = $supervisorId;
        $this->user->id = $supervisorId;
        if ($this->user->isSupervisor() && $this->schedule->isOwner()) {
            $this->schedule->deleteSchedule();
            return success("Schedule deleted successfully", null);
        }
        return unauthorized("User id ". $supervisorId . " is not a supervisor or does not have access to schedule");
    }

    function sendMessage($message) {
        $this->message->scheduleId = $this->schedule->id;
        $this->message->senderId = $this->schedule->supervisorId;
        $this->message->content = $message;
        $this->appointment->scheduleId = $this->schedule->id;
        $appointments = $this->appointment->getAppointmentBySchedule();
        foreach ($appointments as $appointment) {
            $this->message->receiverId = $appointment[COL_USER_ID];
            $this->message->addMessage();
        }
    }

}