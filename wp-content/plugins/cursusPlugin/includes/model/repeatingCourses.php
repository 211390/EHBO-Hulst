<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 05.01.20
 * Time: 15:47 uur
 */

class repeatingCourses
{
    private $repeatingID = "";

    private $title = "";

    private $maxParticipants = "";

    private $description = "";

    private $enableParticipants = "";

    public function setRepeatingID($repeatingID){
        if (intval($repeatingID)) {
            $this->repeatingID = $repeatingID;
        }
    }

    public function setTitle($title){
        if (is_string($title)) {
            $this->title = trim($title);
        }
    }

    public function setMaxParticipants($maxParticipants){
        if (is_string($maxParticipants)) {
            $this->maxParticipants = trim($maxParticipants);
        }
    }

    public function setDate($date){
        if (is_string($date)) {
            $this->date = trim($date);
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

    public function getRepeatingID(){
        return $this->repeatingID;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getMaxParticipants(){
        return $this->maxParticipants;
    }

    public function getDate(){
        return $this->date;
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
            'maxParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            'date' => array('filter' => FILTER_SANITIZE_STRING),
            'description' => array('filter' => FILTER_SANITIZE_STRING),
            'enableParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'repeatingID' => array('filter' => FILTER_VALIDATE_INT)
        );
        // Get filtered input:
        $inputs = filter_input_array(INPUT_POST, $post_check_array);
        // Return to sender
        return $inputs;
    }

    public function getRepeatingCourseById($newID){
        $all_courses = $this->getRepeatingCourseList();
        foreach($all_courses as $course){
            if($course->getRepeatingID() == $newID){
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

            if (!isset($input_array['date'])) {
                // Mandatory fields are missing
                throw new Exception(__("Description veld is verplicht"));
            }

            global $wpdb;

            // Insert query
            $wpdb->query($wpdb->prepare("INSERT INTO `" . $this->getTableName() .
                "` ( `title`, `maxParticipants`, `date` ,`description`, `enableParticipants`)" .
                " VALUES ( '%s', '%d', '%s','%s', '%d');", $input_array['title'], $input_array['maxParticipants'], $input_array['date'], $input_array['description'], $input_array['enableParticipants']));
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
            $array_fields = array('repeatingID', 'title','maxParticipants', 'date','description', 'enableParticipants');
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
                " SET `title` = '%s', `maxParticipants` = '%d',`date` = '%s', `description` = '%s',`enableParticipants` = '%d' " .
                "WHERE `".$this->getTableName()."`.`repeatingID` =%d;", $input_array['title'], $input_array['maxParticipants'], $input_array['date'],$input_array['description'], $input_array['enableParticipants'], $input_array['repeatingID']));

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
            if (!isset($input_array['repeatingID'])){
                throw new Exception(__("Missing mandatory fields"));}
            global $wpdb;

            // Delete row by provided id (Wordpress style)
            $wpdb->delete($this->getTableName(), array('repeatingID' => $input_array['repeatingID']), array('%d')); // Where format
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

    public function getRepeatingCoursesAmount(){
        global $wpdb;

        $query = "SELECT COUNT(*) AS nr FROM `" . $this->getTableName() . "`ORDER BY date";
        $result = $wpdb->get_results($query, ARRAY_A);

        return $result[0]['nr'];
    }

    public function getRepeatingCourseList(){
        global $wpdb;
        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `" . $this->getTableName() . "` ORDER BY `date`", ARRAY_A);

        // For all database results:
        foreach ($result_array as $idx => $array) {
            // New object
            $newCourses = new repeatingCourses();
            // Set all info
            $newCourses->setTitle($array['title']);
            $newCourses->setMaxParticipants($array['maxParticipants']);
            $newCourses->setDate($array['date']);
            $newCourses->setDescription($array['description']);
            $newCourses->setEnableParticipants($array['enableParticipants']);
            $newCourses->setRepeatingID($array['repeatingID']);

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
            'maxParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            'date' => array('filter' => FILTER_SANITIZE_STRING),
            'description' => array('filter' => FILTER_SANITIZE_STRING),
            'enableParticipants' => array('filter' => FILTER_SANITIZE_STRING),
            // Id of current row
            'repeatingID' => array('filter' => FILTER_VALIDATE_INT)
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
                if (!is_null($get_array['repeatingID'])) {
                    $action = $get_array['action'];
                }
                break;

            case 'delete':
                // Delete current id if provided
                if (!is_null($get_array['repeatingID'])) {
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
        return $table = $wpdb->prefix . "cp_repeatingCourse";
    }
}