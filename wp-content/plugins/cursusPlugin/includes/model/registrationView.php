<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 05.01.20
 * Time: 15:49 uur
 */

class registrationView
{
    private $registrationID = "";

    private $name = "";

    private $mail = "";

    private $tel = "";

    private $comment = "";

    private $approval = "";

    private $courseType = "";

    private $repeatingID;

    /**
     * @return string
     */
    private function getTableName()
    {
        return 'wp_cp_registration';
    }

    public function setRegistrationID($registrationID)
    {
        if (intval($registrationID)) {
            $this->registrationID = $registrationID;
        }

        return $this;
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = trim($name);
        }

        return $this;
    }

    public function setMail($mail)
    {
        if (is_string($mail)) {
            $this->mail = trim($mail);
        }

        return $this;
    }

    public function setTel($tel)
    {
        if (is_string($tel)) {
            $this->tel = trim($tel);
        }

        return $this;
    }

    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->comment = trim($comment);
        }

        return $this;
    }

    public function setApproval($approval)
    {
        if (is_string($approval)) {
            $this->approval = trim($approval);
        }

        return $this;
    }

    public function setCourseType($courseType)
    {
        if (empty($courseType)) {
            throw new RuntimeException('The course type may not be NULL or empty.');
        }

        $this->courseType = (int)$courseType;

        return $this;
    }


    public function setRepeatingID($id)
    {
        $this->repeatingID = (int)$id;

        return $this;
    }


    public function getRegistrationID()
    {
        return $this->registrationID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getApproval()
    {
        return (bool)$this->approval;
    }

    public function getCourseType()
    {
        return $this->courseType;
    }

    public function getRepeatingID()
    {
        return $this->repeatingID;
    }

    public function getGetValues()
    {
        // Define the check for params
        $get_check_array = array(
            // Action
            'action' => array('filter' => FILTER_SANITIZE_STRING),
            // List of all fields
            'add' => array('filter' => FILTER_SANITIZE_STRING),
            'update' => array('filter' => FILTER_SANITIZE_STRING),
            'name' => array('filter' => FILTER_SANITIZE_STRING),
            'mail' => array('filter' => FILTER_SANITIZE_STRING),
            'tel' => array('filter' => FILTER_SANITIZE_STRING),
            'comment' => array('filter' => FILTER_SANITIZE_STRING),
            'approval' => array('filter' => FILTER_SANITIZE_STRING),
            'courseType' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'registrationID' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_GET, $get_check_array);
        // RTS
        return $inputs;
    }

    public function getPostValues()
    {
        // Define the check for params
        $post_check_array = array(
            // submit action
            'action' => array('filter' => FILTER_SANITIZE_STRING),
            // List of all fields
            'add' => array('filter' => FILTER_SANITIZE_STRING),
            'update' => array('filter' => FILTER_SANITIZE_STRING),
            'name' => array('filter' => FILTER_SANITIZE_STRING),
            'studentName' => array('filter' => FILTER_SANITIZE_STRING),
            'mail' => array('filter' => FILTER_SANITIZE_STRING),
            'tel' => array('filter' => FILTER_SANITIZE_STRING),
            'comment' => array('filter' => FILTER_SANITIZE_STRING),
            'approval' => array('filter' => FILTER_SANITIZE_STRING),
            'courseType' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'registrationID' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
        // Return to sender
        return $inputs;
    }

    /**
     * @param newCourses $course
     *
     * @return bool
     */
    public function canRegister($course)
    {
        if (empty($course->getMinParticipants()) || $course->getMinParticipants() <= 0) {
            return false;
        }

        return true;
    }

    /**
     * @param newCourses $course
     *
     * @throws Exception
     *
     * @return array
     */
    public function getRegistrations($course)
    {
        if ($course instanceof newCourses) {
            $results = $this->getRegistrationsFromNewCourse($course);
        } elseif ($course instanceof repeatingCourses) {
            $results = $this->getRegistrationsFromRepeatingCourse($course);
        } else {
            throw new Exception('Er is iets fout gegaan.');
        }

        return $results;
    }

    /**
     * @param newCourses $course
     *
     * @return array
     */
    private function getRegistrationsFromNewCourse($course)
    {
        global $wpdb;

        $id = $course->getNewID();

        $results = $wpdb->get_results("SELECT * FROM {$this->getTableName()} WHERE courseType = {$id}", ARRAY_A);

        return $results;
    }

    /**
     * @param repeatingCourses $course
     *
     * @return array
     */
    private function getRegistrationsFromRepeatingCourse($course)
    {
        global $wpdb;

        $id = $course->getRepeatingID();

        $results = $wpdb->get_results("SELECT * FROM {$this->getTableName()} WHERE repeatingID = {$id}", ARRAY_A);

        return $results;
    }

    public function isSubmit($post_inputs)
    {

    }

    public function getRegistrationAmount()
    {
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `" . $this->getTableName() . "`";
        $result = $wpdb->get_results($query, ARRAY_A);

        return $result[0]['nr'];
    }

    public function getRegistrationList()
    {
        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $this->getTableName() . "` ORDER BY `id`", ARRAY_A);


        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $registrationView = new registrationView();
            // Set all info
            $registrationView->setName($array['name']);
            $registrationView->setMail($array['mail']);
            $registrationView->setTel($array['tel']);
            $registrationView->setComment($array['comment']);
            $registrationView->setApproval($array['approval']);
            $registrationView->setCourseType($array['courseType']);
            $registrationView->setRegistrationID($array['registrationID']);

            // Add new object toe return array.
            $return_array[] = $registrationView;
        }
        return $return_array;
    }

    public function save()
    {
        try {
            if (empty($this->name)) {
                // Mandatory fields are missing
                throw new Exception("Naam veld is verplicht");
            }

            if (empty($this->mail)) {
                // Mandatory fields are missing
                throw new Exception("E-mail veld is verplicht");
            }

            if (empty($this->tel)) {
                // Mandatory fields are missing
                throw new Exception("Telefoonnummer veld is verplicht");
            }

            if (empty($this->courseType) && empty($this->repeatingID)) {
                // Mandatory fields are missing
                throw new Exception("Er ging iets fout tijdens het opslaan.");
            }

            global $wpdb;

            // Insert query
            $wpdb->query(
                $wpdb->prepare("INSERT INTO `" . $this->getTableName() .
                    "` (`name`, `mail`,`tel`,`comment`, `approval`, `courseType`, `repeatingID`)" .
                    " VALUES ('%s', '%s','%s', '%s', '0', '%d', '%d');", $this->name, $this->mail, $this->tel, $this->comment, $this->courseType, $this->repeatingID)
            );

            if (!empty($this->courseType)) {
                $this->sendMailToAdminAfterRegistration($wpdb->insert_id, $this->courseType, 'new');
            } elseif (!empty($this->repeatingID)) {
                $this->sendMailToAdminAfterRegistration($wpdb->insert_id, $this->repeatingID, 'repeat');
            } else {
                throw new Exception('Er is iets fout gegaan tijdens het mailen van de beheerder.');
            }

            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {
                $this->last_error = $wpdb->last_error;
                return FALSE;
            }

        } catch (Exception $exc) {
            // @todo: Add error handling
            echo '<pre>' . $exc->getTraceAsString() . '</pre>';
        }

        return TRUE;
    }

    private function sendMailToAdminAfterRegistration($registrationId, $cursusId, $cursusType)
    {
        global $wpdb;

        if ($cursusType === 'new') {
            $course = $wpdb->get_row("SELECT wp_cp_newcourse.title FROM wp_cp_newcourse INNER JOIN wp_cp_registration ON wp_cp_registration.courseType = wp_cp_newcourse.newID WHERE wp_cp_registration.courseType={$cursusId}");
        }

        if ($cursusType === 'repeat') {
            $course = $wpdb->get_row("SELECT wp_cp_newcourse.title FROM wp_cp_newcourse INNER JOIN wp_cp_registration ON wp_cp_registration.courseType = wp_cp_newcourse.newID WHERE wp_cp_registration.courseType={$cursusId}");
        }

        $wpdb->query("UPDATE wp_cp_registration SET approval = 1 WHERE registrationID ={$registrationId}");
        mail(get_option('admin_email'), 'Er is een nieuwe inschrijving voor een cursus', 'Er is een nieuwe inschrijving voor de cursus ' . $course->title);
    }

    public function update($input_array)
    {
        try {
            $array_fields = array('registrationID', 'name', 'mail', 'tel', 'comment', 'approval', 'courseType');
            $data_array = array();

            // Check fields
            foreach ($array_fields as $field) {

                // Check fields
                if (!isset($input_array[$field])) {
                    throw new Exception(__("$field is mandatory for update."));
                }
                // Add data_array (without hash idx)
                // (input_array is POST data -> Could have more fields)
                $data_array[] = $input_array[$field];
            }
            global $wpdb;

            // Update query
            //*
            $wpdb->query($wpdb->prepare("UPDATE " . $this->getTableName() .
                " SET `name` = '%s', `mail` = '%s',`tel` = '%s',`comment` = '%s', `approval` = '%d', `courseType` = '%d' " .
                "WHERE `" . $this->getTableName() . "`.`registrationID` =%d;", $input_array['name'], $input_array['mail'], $input_array['tel'], $input_array['comment'], $input_array['approval'], $input_array['courseType'], $input_array['registrationID']));

        } catch (Exception $exc) {

            // @todo: Fix error handlin
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return FALSE;
        }
        return TRUE;
    }

    public function delete($input_array)
    {
        try {
            // Check input id
            if (!isset($input_array['registrationID'])) {
                throw new Exception(__("Missing mandatory fields"));
            }
            global $wpdb;

            // Delete row by provided id (Wordpress style)
            $wpdb->delete($this->getTableName(), array('registrationID' => $input_array['registrationID']), array('%d')); // Where format
            //*/
            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {

                throw new Exception($wpdb->last_error);
            }
        } catch (Exception $exc) {
            // @todo: Add error handling
            echo '<pre>';
            $this->last_error = $exc->getMessage();
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
            echo '</pre>';
        }
        return TRUE;
    }

    public function handleGetAction($get_array)
    {
        $action = '';

        switch ($get_array['action']) {
            case 'update':
                // Indicate current action is update if id provided
                if (!is_null($get_array['registrationID'])) {
                    $action = $get_array['action'];
                }
                break;

            case 'delete':
                // Delete current id if provided
                if (!is_null($get_array['registrationID'])) {
                    $this->delete($get_array);
                }
                $action = 'delete';
                break;

            default:
                // Oops
                break;
        }
        return $action;
    }

    public function getNewCourseByID($newID)
    {
        return $this->newID;
    }

    public function getRepeatingCourseByID($repeatingID)
    {
        return $this->repeatingID;
    }

    public function registrationAlertMail()
    {

    }

    public function approvalMail()
    {

    }
}