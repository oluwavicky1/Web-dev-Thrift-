<?php

require_once 'DbHelper.php';
require_once 'utils/constants.php';

define('COL_ID', 'id');
define('COL_NAME', 'name');
define('COL_START_DATE', 'start_date');
define('COL_END_DATE', 'end_date');

class Semester
{
    public int $id;
    public string $name;
    public $startDate;
    public $endDate;
    private DbHelper $db;

    function __construct($db)
    {
        $this->db = $db;
        $this->db->tableName = 'semester';
    }

    function createSemester() {
        return $this->db->insert(
            array(
                COL_START_DATE => $this->startDate,
                COL_END_DATE => $this->endDate,
                COL_NAME => $this->name
            ),
            array(COL_END_DATE, COL_START_DATE, COL_NAME)
        );
    }

    function deleteSemesterById(int $id) {
        return $this->db->delete(array(COL_ID => $id));
    }

    function deleteSemesterByName(string $name) {
        return $this->db->delete(array(COL_NAME => $name));
    }

    function getSemesters() {
        return $this->db->select(array())[RESPONSE_DATA];
    }

    function getSemesterById(int $id) {
        return $this->db->select(array(COL_ID => $id))[RESPONSE_DATA];
    }

    function getSemesterByName(string $name) {
        return $this->db->select(array(COL_NAME => $name))[RESPONSE_DATA];
    }

}