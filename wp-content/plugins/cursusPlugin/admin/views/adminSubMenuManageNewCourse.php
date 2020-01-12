<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 05.01.20
 * Time: 15:45 uur
 */


// Add model
include COURSE_PLUGIN_MODEL_DIR . "/newCourses.php";

// Add stylesheet.
wp_enqueue_style('style', '/wp-content/plugins/cursusPlugin/admin/views/stylesheet_admin.css');

// Declare the class
$newCourses = new newCourses();

// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__, ".php"));

// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the POST data in filtered array
$post_array = $newCourses->getPostValues();

// Get the action and put it in the 'action' variable
$action = $_GET['action'];

// Determine value enableParticipants by existance of minParticipants
if ($action == 'update') {
    $minParticipants = $post_array['minParticipants'];
    if ($minParticipants == '' || $minParticipants == 0) {
        $post_array['enableParticipants'] = 1;
    } else {
        $post_array['enableParticipants'] = 0;
    }
    $newCourses->update($post_array);
}

// Deletes course when 'delete' action is performed
if ($action == 'delete') {
    $array['newID'] = $_GET['newID'];
    $newCourses->delete($array);
}

// Get the data from 'getNewCourseList()' and put it in the 'all_courses' variable
$all_courses = $newCourses->getNewCourseList();

// Get the View
$view = $_GET['view'];

// Updates perameters when view is updated
if ($view == 'update') {
    // Create update link
    $params = array('action' => 'update');
    // add params to base url update link
    $upd_link = add_query_arg($params, $base_url);

    // Gets 'newID' and puts it into the 'current_course' variable
    $current_course = $newCourses->getNewCourseById($_GET['newID']);
    ?>

    <!--HEADER TITLE-->
    <h1 id="headerTitle">Beheren Nieuwe Cursus</h1>

    <!--COURSE MANAGING FORM-->
    <form method="post" action="<?= $upd_link ?>">
        <input type="hidden" name="newID" value="<?php echo $current_course->getNewID(); ?>">
        <!--COURSE FIELDS TABLE-->
        <table class="manageNewCourse">
            <tr>
                <!--TITLE HEAD-->
                <td><h6 class="backendForm_head">Titel</h6></td>
                <!--PARTICIPANTS HEAD-->
                <td><h6 class="backendForm_head">Minimum aantal deelnemers</h6></td>
            </tr>
            <tr>
                <!--TITLE INPUT-->
                <td><input class="editTitelInput" type="text" name="title"
                           value="<?php echo $current_course->getTitle(); ?>"></td>
                <!--PARTICIPANTS INPUT-->
                <td><input class="editAantalDeelnemersInput" type="number" name="minParticipants"
                           value="<?php echo $current_course->getMinParticipants(); ?>"</td>
            </tr>
            <!--DESCRIPTION HEAD-->
            <tr>
                <td><h6 class="backendForm_head">Omschrijving</h6></td>
            </tr>
            <!--DESCRIPTION-->
            <tr>
                <td><textarea class="editOmschrijvingInput"
                              name="description"><?php echo $current_course->getDescription(); ?></textarea></td>
            </tr>
            <!--UPDATE COURSE BUTTON-->
            <tr>
                <td><input class="formUpdate" type="submit" value="Cursus bijwerken"></td>
            </tr>
        </table>
    </form>

    <!--REGISTRATIONS TABLE-->
    <table id="courseList" cellspacing="0" cellpadding="0">
        <thead>
        <!--HEADER TITLE-->
        <td><h1 id="headerTitle">Registraties</h1></td>
        </thead>
        <!--REGISTRATION ROW-->
        <tr id='courseListRow'>
            <!--COURSE LIST ITEM TITLE-->
            <td id='courseListTitle'>Registratie voorbeeld titel</td>
            <!--COURSE LIST BUTTONS-->
            <td id='courseButtons'>
                <button class="courseInfo">Meer Informatie</button>
                <!--COURSE LIST APPROVE BUTTON-->
                <form method='post' action=''
                <input type='hidden' name='update' value=''>
                <input class='courseListApprove' onclick='return confirm("Weet je zeker dat je dit wilt Goedkeuren?");'
                       type='submit' value='&#10004;'>
                </form>
                <!--COURSE LIST DISAPPROVE BUTTON-->
                <form method='post' action=''>
                    <input type='hidden' name='delete' value=''>
                    <input class='courseListDisapprove'
                           onclick='return confirm("Weet je zeker dat je dit wilt Afkeuren & Verwijderen?");'
                           type='submit' value='&#10006;'>
                </form>
            </td>
        </tr>
    </table>

    <!--COURSE LIST-->
    <?php
} else {
    echo '
    <table id="courseList" cellspacing="0" cellpadding="0">
        <thead>
            <!--HEADER TITLE-->
            <td><h1 id="headerTitle">Nieuwe Cursussen</h1></td>
        </thead>
';
    // Determines Delete or Update action per course
    foreach ($all_courses as $obj) {
        // Create update link
        $params = array('view' => 'update', 'newID' => $obj->getNewID());
        // add params to base url update link
        $upd_link = add_query_arg($params, $base_url);
        // Create delete link
        $params = array('action' => 'delete', 'newID' => $obj->getNewID());
        // Add params to base url delete link
        $del_link = add_query_arg($params, $base_url);

        echo "
    <!--COURSE LIST ROW-->
    <tr id='courseListRow'>
        <!--COURSE LIST ITEM TITLE-->
        <td id='courseListTitle'>{$obj->getTitle()}</td>
        <!--COURSE LIST BUTTONS-->
        <td id='courseButtons'>
            <!--COURSE LIST UPDATE BUTTON-->
            <form method='post' action='{$upd_link}'>
                <input type='hidden' name='update' value='{$obj->getNewID()} '>
                <input class='courseListSelect' type='submit' value='&#10095;'>
            </form>
            <!--COURSE LIST DELETE BUTTON-->
            <form method='post' action='{$del_link}'>
                <input type='hidden' name='delete' value='{$obj->getNewID()}'>
                <input class='courseListDelete' onclick='return confirm(\"Weet je zeker dat je dit wilt verwijderen?\");' type='submit' value='&#10006;'>
            </form>
        </td>
    </tr>
    ";
    } // end foreach
} // end else

