<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 05.01.20
 * Time: 15:47 uur
 */

class newCourses
{
    private $newID = "";

    private $title = "";

    private $minParticipants = "";

    private $description = "";

    private $enableParticipants = "";

    public function setNewID($newID){
        if (intval($newID)) {
            $this->newID = $newID;
        }
    }

    public function setTitle($title){
        if (is_string($title)) {
            $this->title = trim($title);
        }
    }

    public function setMinParticipants($minParticipants){
        if (is_string($minParticipants)) {
            $this->minParticipants = trim($minParticipants);
        }
    }

    public function setDescription($description){
        if (is_string($description)) {
            $this->description = trim($description);
        }
    }

    public function setEnableParticipants($enableParticipants){
        if (is_string($enableParticipants)) {
            $this->enableParticipants = trim($enableParticipants);
        }
    }

    public function getNewID(){
        return $this->newID;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getMinParticipants(){
        return $this->minParticipants;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getEnableParticipants(){
        return $this->enableParticipants;
    }

    public function getPostValues(){
        // Define the check for params
        $post_check_array = array(
            // submit action
            'add' => array('filter' => FILTER_SANITIZE_STRING),
            'update' => array('filter' => FILTER_SANITIZE_STRING),
            // List all update form fields !!!
            'title' => array('filter' => FILTER_SANITIZE_STRING),
            'minParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            'description' => array('filter' => FILTER_SANITIZE_STRING),
            'enableParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'newID' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
        // Return to sender
        return $inputs;
    }

    public function getNewCourseById($newID){
        $all_courses = $this->getNewCourseList();
        foreach($all_courses as $course){
            if($course->getNewID() == $newID){
                return $course;
            }
        }
    }

    public function save($input_array){
        try {
            if (!isset($input_array['title'])) {
                // Mandatory fields are missing
                throw new Exception(__("Titel veld is verplicht"));
            }

            if (!isset($input_array['description'])) {
                // Mandatory fields are missing
                throw new Exception(__("Description veld is verplicht"));
            }

            global $wpdb;

            // Insert query
            $wpdb->query($wpdb->prepare("INSERT INTO `" . $this->getTableName() .
                "` ( `title`, `minParticipants`,`description`, `enableParticipants`)" .
                " VALUES ( '%s', '%d','%s', '%d');", $input_array['title'], $input_array['minParticipants'], $input_array['description'], $input_array['enableParticipants']));
            // Error ? It's in there:
            if (!empty($wpdb->last_error)) {
                $this->last_error = $wpdb->last_error;
                return FALSE;
            }

        } catch (Exception $exc) {
            // @todo: Add error handling
            echo '<pre>' . $exc->getTraceAsString() . ' < / pre>';
        }

        return TRUE;
    }

    public function update($input_array){
        try {
            $array_fields = array('newID', 'title','minParticipants', 'description', 'enableParticipants');
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
                " SET `title` = '%s', `minParticipants` = '%d',`description` = '%s',`enableParticipants` = '%d' " .
                "WHERE `".$this->getTableName()."`.`newID` =%d;", $input_array['title'], $input_array['minParticipants'], $input_array['description'], $input_array['enableParticipants'], $input_array['newID']));

        } catch (Exception $exc) {

            // @todo: Fix error handlin
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();
            return FALSE;
        }
        return TRUE;
    }

    public function delete($input_array){
        try {
            // Check input id
            if (!isset($input_array['newID'])){
                throw new Exception(__("Missing mandatory fields"));}
            global $wpdb;

            // Delete row by provided id (Wordpress style)
            $wpdb->delete($this->getTableName(), array('newID' => $input_array['newID']), array('%d')); // Where format
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

    public function getNewCoursesAmount(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `" . $this->getTableName() . "`";
        $result = $wpdb->get_results($query, ARRAY_A);

        return $result[0]['nr'];
    }

    public function getNewCourseList(){
        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $this->getTableName() . "` ORDER BY `newid`", ARRAY_A);

        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $newCourses = new newCourses();
            // Set all info
            $newCourses->setTitle($array['title']);
            $newCourses->setMinParticipants($array['minParticipants']);
            $newCourses->setDescription($array['description']);
            $newCourses->setEnableParticipants($array['enableParticipants']);
            $newCourses->setNewID($array['newID']);

            // Add new object toe return array.
            $return_array[] = $newCourses;
        }
        return $return_array;
    }

    public function showApprovalAmount(){

    }

    public function getGetValues(){
        // Define the check for params
        $get_check_array = array(
            // Action
            'action' => array('filter' => FILTER_SANITIZE_STRING),
            'title' => array('filter' => FILTER_SANITIZE_STRING),
            'minParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            'description' => array('filter' => FILTER_SANITIZE_STRING),
            'enableParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'newID' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_GET, $get_check_array);
        // RTS
        return $inputs;
    }

    public function handleGetAction($get_array){
        $action = '';

        switch ($get_array['action']) {
            case 'update':
                // Indicate current action is update if id provided
                if (!is_null($get_array['newID'])) {
                    $action = $get_array['action'];
                }
                break;

            case 'delete':
                // Delete current id if provided
                if (!is_null($get_array['newID'])) {
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

    public function getTableName(){
        global $wpdb;
        return $table = $wpdb->prefix . "cp_newCourse";
    }

    public function getRegistrations($id)
    {
        $intId = (int) $id;
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM wp_cp_registration WHERE courseType = {$intId}");
        return $results;
    }

    public function setRegistrationToYes($id)
    {
        global $wpdb;
        $mail = $wpdb->get_row("SELECT mail FROM wp_cp_registration WHERE registrationID={$id}");
        $courseid = $wpdb->get_row("SELECT courseType FROM wp_cp_registration WHERE registrationID = {$id}");
        $courseid = (int) $courseid->courseType;

        $course = $wpdb->get_row("SELECT wp_cp_newcourse.title FROM wp_cp_newcourse INNER JOIN wp_cp_registration ON wp_cp_registration.courseType = wp_cp_newcourse.newID WHERE wp_cp_registration.courseType={$courseid}");
        $wpdb->query("UPDATE wp_cp_registration SET approval = 1 WHERE registrationID ={$id}");
        mail($mail->mail, 'Goed keuring registratie', 'U bent goedgekeurd voor de ' . $course->title);
    }

    public function setRegistrationToDenied($id)
    {
        global $wpdb;
        $mail = $wpdb->get_row("SELECT mail FROM wp_cp_registration WHERE registrationID={$id}");
        $courseid = $wpdb->get_row("SELECT courseType FROM wp_cp_registration WHERE registrationID = {$id}");
        $courseid = (int) $courseid->courseType;

        $course = $wpdb->get_row("SELECT wp_cp_newcourse.title FROM wp_cp_newcourse INNER JOIN wp_cp_registration ON wp_cp_registration.courseType = wp_cp_newcourse.newID WHERE wp_cp_registration.courseType={$courseid}");
        $wpdb->query("DELETE FROM wp_cp_registration WHERE registrationID ={$id}");
        mail($mail->mail, 'Fout keuring registratie', 'U bent afgekeurd voor de ' . $course->title);
    }
}
