<?php
require_once '../DbHelper.php';
require_once '../utils/constants.php';

define("TABLE_NAME", "user");
define("COL_ID", "id");
define("COL_FIRSTNAME", "first_name");
define("COL_SURNAME", "surname");
define("COL_EMAIL", "email");
define("COL_PASSWORD", "PASSWORD");
define("COL_PROFILE_PICTURE", "profile_picture");
define("COL_TYPE", "type");
define("COL_DATE_CREATED", "date_created");

define("REQUIRED_COLUMNS", array(COL_FIRSTNAME, COL_SURNAME, COL_EMAIL, COL_PASSWORD, COL_TYPE));
define("SEARCH_COLUMNS", array(COL_FIRSTNAME, COL_SURNAME, COL_EMAIL, COL_ID, COL_TYPE));

class User
{
    private $dbHelper;
    public $id;
    public $firstName;
    public $surname;
    public $email;
    public $password;
    public $type;
    public $profileImageUrl;

    function __construct(DbHelper $db)
    {
        $this->dbHelper = $db;
    }

    function addUser() {
        $user = null;
        if (isset($this->email)) {
            $user = $this->filterUsers($this->email, COL_EMAIL);
        }
        if ($user[RESPONSE_STATUS] != DbResponse::STATUS_SUCCESS) {
            return $this->dbHelper->insert(array(
                COL_FIRSTNAME => $this->firstName,
                COL_TYPE => $this->type,
                COL_SURNAME => $this->surname,
                COL_EMAIL => $this->email,
                COL_PASSWORD => password_hash($this->password, PASSWORD_DEFAULT),
                COL_PROFILE_PICTURE => $this->profileImageUrl
            ), REQUIRED_COLUMNS);
        } else {
            $response[RESPONSE_STATUS] = DbResponse::STATUS_ERROR;
            $response[RESPONSE_MESSAGE] = "User already exists";
            $response[RESPONSE_DATA] = null;
            return $response;
        }
    }

    private function filterUsers($value, $colName): array{
        return $this->dbHelper->select(array($colName => $value));
    }

    function getUserByEmail($email) {
        return $this->filterUsers($email, COL_EMAIL);
    }

    function getUsers(): array {
        return $this->dbHelper->select(array());
    }

    function updateUserByEmail(String $email, array $values) {
        return $this->dbHelper->update($values, array(COL_EMAIL => $email), array());
    }

    function updateUserById(int $id, array $values) {
        return $this->dbHelper->update($values, array(COL_ID => $id), array());
    }

    function deleteUser(User $user) {
        if (isset($user->id)) {
            return $this->dbHelper->delete(array(COL_ID => $user->id));
        } else {
            return $this->dbHelper->delete(array(COL_EMAIL => $user->email));
        }
    }
}