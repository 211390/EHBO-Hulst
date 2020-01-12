<?php
/**
 * Created by PhpStorm.
 * User: thijs
 * Date: 05.01.20
 * Time: 15:45 uur
 */


// Add model
include COURSE_PLUGIN_MODEL_DIR . "/newCourses.php";

// Declare the class
$newCourses = new newCourses();


// add the base_url to a specific variable
$params = array('page' => basename(__FILE__, ".php"));

// add parameters to base_url
$base_url = add_query_arg($params, $base_url);

// Puts the data from the 'getNewCourseList()' function into the 'newCourses_list' variable
$newCourses_list = $newCourses->getNewCourseList();

// Grab the GET values and add to $get_array
$get_array = $newCourses->getGetValues();

//Follow the actions
$action = FALSE;

//Determines existance of action, if true, determines choice between Delete & Update
if (!empty($get_array)) {
    // Check acties
    if (isset($get_array['action'])) {
        $action = $newCourses->handleGetAction($get_array);
    }
}

// Put POST data from POST values in $post_array
$post_array = $newCourses->getPostValues();

// collect errors
$error = FALSE;

// Check add form
$add = FALSE;

// Check post data
if (!empty($post_array)) {
    // Determine value enableParticipants by existance of minParticipants
    if (isset($post_array['add'])) {
        // Save opleiding
        $minParticipants = $post_array['minParticipants'];
        if ($minParticipants == '' || $minParticipants == 0) {
            $post_array['enableParticipants'] = 1;
        } else {
            $post_array['enableParticipants'] = 0;
        }
        $result = $newCourses->save($post_array);
        if ($result) {
            // Save has succeeded.
            $add = TRUE;
        } else {
            // show error
            $error = TRUE;
        }
    }
    // Check the update form
    if (isset($post_array['update'])) {
        // Save opleiding
        $newCourses->update($post_array);
    }
}
// Add stylesheet.
wp_enqueue_style('style', '/wp-content/plugins/cursusPlugin/admin/views/stylesheet_admin.css');
?>
    <!--HEADER TITLE-->
    <h1 id="headerTitle">Aanmaken Nieuwe Cursus</h1>

    <!--MAIN CREATE COURSE DIV-->
    <div class="createCourse">
<?php
echo($add ? "<p style='margin-top:20px;' class='alert alert-success text-center'><strong>Nieuwe Cursus succesvol aangemaakt!</strong></p>" : "");
// Check if the action is updated, start form when true.
echo(($action == 'update') ? '<form action="' . $base_url . '"method="post">' : '');

// When there is no update, load form
if ($action !== 'update') {
    ?>
    <!--COURSE CREATION FORM-->
    <form action="<?php echo $base_url; ?>" method="post">
        <!--TITLE-->
        <div class="titleField">
            <h6 class="backendForm_head">Titel</h6>
            <input class="titleInput" type="text" name="title" required>
        </div>
        <!--PARTICIPANTS-->
        <div class="participantsField">
            <h6 class="backendForm_head">Minimum aantal deelnemers</h6>
            <input class="participantsInput" type="text" name="minParticipants">
        </div>
        <!--DESCRIPTION-->
        <div class="descriptionField">
            <h6 class="backendForm_head">Omschrijving</h6>
            <textarea class="descriptionInput" name="description" required></textarea>
        </div>
        <!--SUBMIT COURSE BUTTON-->
        <div class="formButton">
            <input class="formSubmit" type="submit" name="add" value="Cursus aanmaken">
        </div>
    </form>
    </div>

    <?php
    // End previous 'if' statement
}
?>