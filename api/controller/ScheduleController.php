<?php
require_once '../utils/helpers.php';
require_once '../utils/constants.php';
require_once '../model/Schedule.php';
require_once '../model/User.php';
require_once '../model/Semester.php';


class ScheduleController
{
    private Schedule $schedule;
    private User $user;
    private Semester $semester;

    function __construct()
    {
        $db = new DbHelper();
        $this->schedule = new Schedule($db);
        $this->user = new User($db);
        $this->semester = new Semester($db);
    }

    function createSchedule($schedule) {
        $this->user->id = $schedule->supervisorId;
        if ($this->user->isSupervisor()) {
            $this->schedule->studentLimit = $schedule->studentLimit;
            $this->schedule->time = $schedule->time;
            $this->schedule->day = $schedule->day;
            $this->schedule->supervisorId = $schedule->supervisorId;
            $this->schedule->createSchedule();
            return success("Schedule created successfully", null);
        }
        return unauthorized("User id ". $schedule->supervisorId . " is not a supervisor");
    }

    function getScheduleBySupervisor($supervisorId, $semesterId) {
        $this->user->id = $supervisorId;
        if ($this->user->isSupervisor()) {
            $this->schedule->supervisorId = $supervisorId;
            $resp = $this->schedule->getSchedulesBySupervisor();
            if (isset($semesterId)) {
                $this->schedule->semesterId = $semesterId;
                $resp = array_filter($resp, function($schedule) {
                    return $schedule[COL_SEMESTER_ID] == $this->schedule->semesterId;
                });
            }
            return success("Schedules requested", $resp);
        }
        return unauthorized("User id ". $supervisorId . " is not a supervisor");
    }

    function getSchedules() {
        return success("Schedules requested", $this->schedule->getSchedules());
    }

    function getSchedulesBySemester($semesterId) {
        $this->schedule->semesterId = $semesterId;
        return success("Schedules requested", $this->schedule->getSchedulesBySemester());
    }

    function getSchedule($id) {
        $this->schedule->id = $id;
        return success("Schedules requested", $this->schedule->getSchedule());
    }

    function updateSchedule($schedule) {
        $this->user->id = $schedule->supervisorId;
        $this->schedule->id = $schedule->id;
        $this->schedule->studentLimit = $schedule->studentLimit;
        $this->schedule->time = $schedule->time;
        $this->schedule->day = $schedule->day;
        $this->schedule->supervisorId = $schedule->supervisorId;
        $this->schedule->semesterId = $schedule->semesterId;
        if ($this->user->isSupervisor() && $this->schedule->isOwner()) {
            return success("Schedule updated successfully", $this->schedule->updateSchedule());
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

}