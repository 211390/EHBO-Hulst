<?php

/**
 * Created by PhpStorm.
 * User: Thijs van der Poel
 * Date: 18/11/2019
 */
/*
 * Template Name: EHBO Hulst Programma
 * Description: Deze template is voor uw programma pagina
 */
get_header();

// Add model
include_once WP_PLUGIN_DIR . '/cursusPlugin/includes/model/registrationView.php';

// Declare the class
$registrationView = new registrationView();

$post_array = $registrationView->getPostValues();

$add = FALSE;
$error = FALSE;

// Check post data
if (!empty($post_array)) {
    // Determine value enableParticipants by existance of minParticipants
    if (isset($post_array['add'])) {
        // Save opleiding
        $result = $registrationView->save($post_array);
        if ($result) {
            // Save has succeeded.
            $add = TRUE;
        } else {
            // show error
            $error = TRUE;
        }
    }
}

?>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<script>
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
</script>

<!--CONTENT-->
<div class="content">

    <!--INNER CONTENT-->
    <div class="inner-content grid-x grid-margin-x ">

        <!--MAIN GRID SECTION-->
        <main class="main small-12 medium-12 large-12 cell" role="main">

            <!--INFO ROW-->
            <div class="grid-x">

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

                <!--INFO COLUMN-->
                <div class="cell small-10 medium-10 large-10">

                    <div class="spacer"></div>

                    <h1>Onze Cursussen</h1>

                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        get_template_part('parts/loop', 'page');
                    endwhile; endif; ?>

                    <!--HEIGHT SPACER-->
                    <div class="spacer"></div>
                </div>

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

            </div>

            <!--NEW COURSE ROW-->
            <div class="grid-x">

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

                <?php

                include_once WP_PLUGIN_DIR . '/cursusPlugin/includes/model/newCourses.php';
                $newCourses = new newCourses();
                $all_courses = $newCourses->getNewCourseList();
                //shorthand if
                $current_id = $newCourses->getPostValues()['newID'] ? $newCourses->getPostValues()['newID'] : $all_courses[0]->getNewID();
                $current_course = $newCourses->getNewCourseById($current_id);
                $current_course_index = null;
                foreach ($all_courses as $idx => $course) {
                    if ($current_id == $course->getNewID()) {
                        $current_course_index = $idx;
                    }
                }
                ?>

                <!--NEW COURSE COLUMN-->
                <div class="newsColumn cell small-12 medium-10 large-10">

                    <!--NEW COURSES-->
                    <div id="upperCourseSlant"></div>
                    <div class="grid-x newCourse">

                        <!--HEADER-->
                        <h4 class="newCourse_header">Nieuwe Cursussen</h4>
                        <!--PAGINATION LEFT-->
                        <div class="cell small-1 medium-1 large-1">
                            <!--HEIGHT SPACER-->
                            <div style="height: 30%;"></div>
                            <!--PREVIOUS COURSES-->
                            <?php
                            if ($current_course->getNewID() !== $all_courses[0]->getNewID()) {
                                ?>
                                <div>
                                    <form method="post">
                                        <input type="hidden" name="newID"
                                               value="<?= $all_courses[$current_course_index - 1]->getNewID(); ?>">
                                        <input type="image" name="submit" alt="Submit" id="courseLeftArrow"
                                               class="show-for-large"
                                               src="http://localhost/ehbo-hulst/wp-content/uploads/2020/01/Course-Arrow-Left.png">
                                    </form>
                                </div>
                            <?php } ?>
                            <!--HEIGHT SPACER-->
                            <div style="height: 50%;"></div>
                        </div>
                        <!--NEWCOURSE CONTENT-->
                        <div class="small-10 medium-10 large-10 cell">
                            <div class="newCourse_container">
                                <h5 class="newCourse_title"><?= $current_course->getTitle(); ?></h5>
                                <div class="newCourse_text"><?= $current_course->getDescription(); ?></div>
                            </div>
                        </div>
                        <!--PAGINATION RIGHT-->
                        <div class="cell small-1 medium-1 large-1">
                            <!--HEIGHT SPACER-->
                            <div style="height: 30%;"></div>
                            <!--NEXT COURSES-->
                            <?php
                            if ($current_course->getNewID() !== end($all_courses)->getNewID()) {
                                ?>
                                <div>
                                    <form method="post">
                                        <input type="hidden" name="newID"
                                               value="<?php echo $all_courses[$current_course_index + 1]->getNewID(); ?>">
                                        <input type="image" name="submit" alt="Submit" id="courseRightArrow"
                                               class="show-for-large"
                                               src="http://localhost/ehbo-hulst/wp-content/uploads/2020/01/Course-Arrow-Right.png">
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--REGISTRATION-->
                    <div class="grid-x newCourseRegister" id="registrationSection">
                        <div class="cell small-1 medium-1 large-1"></div>
                        <!--REGISTRATION FORM-->
                        <form class="newCourseForm small-10 medium-10 large-10 cell" method="post">
                            <input type="hidden" name="newID" value="<?php echo $current_course->getNewID(); ?>">
                            <div class="naamVeld">
                                <h6 class="newCourse_title">Naam</h6>
                                <input class="naamInput" name="name">
                            </div>
                            <div class="emailVeld">
                                <h6 class="newCourse_title">E-mail</h6>
                                <input class="emailInput" name="mail">
                            </div>
                            <div class="telVeld">
                                <h6 class="newCourse_title">Telefoonnummer</h6>
                                <input class="telInput" name="tel">
                            </div>
                            <div class="berichtVeld">
                                <h6 class="newCourse_title">Bericht</h6>
                                <textarea class="berichtInput" name="comment"></textarea>
                            </div>
                            <div class="courseType">
                                <input type="hidden" name="courseType" value="<?= $current_course->getNewID() ?>">
                            </div>
                            <!--REGISTRATIONS & REGISTRATION SUBMIT-->
                            <div class="grid-x">
                                <div class="cell small-0 medium-2 large-7"></div>
                                <!--Amount of participants; Je kunt per Cursus ID kijken hoeveel mensen zich hebben ingeschreven op dat ID-->
                                <p class="newCourse_participants cell small-12 medium-4 large-2"> <?php echo '?' . '/' . $current_course->getMinParticipants() . ' Inschrijvingen'; ?></p>
                                <!--SUBMIT REGISTRATION-->
                                <div class="cell small-12 medium-4 large-2">
                                        <button type="submit" name="add" class="newRegistrationSubmit" formaction="registerToCourse">Inschrijven
                                        </button>
                                </div>
                            </div>
                        </form>
                        <div class="cell small-1 medium-1 large-1"></div>
                    </div>
                    <div id="lowerCourseSlant"></div>

                    <!--MOBILE PAGINATION-->
                    <div class="newCoursePagination hide-for-large">
                        <!--PREVIOUS COURSES-->
                        <?php
                        if ($current_course->getNewID() !== $all_courses[0]->getNewID()) {
                            ?>
                            <div id="mobileCourse_leftArrow">
                                <form method="post">
                                    <input type="hidden" name="newID"
                                           value="<?php echo $all_courses[$current_course_index - 1]->getNewID(); ?>">
                                    <input type="image" name="submit" alt="Submit" id="courseLeftArrow"
                                           src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/Arrow-Left.png">
                                </form>
                            </div>
                        <?php } ?>
                        <!--NEXT COURSES-->
                        <?php
                        if ($current_course->getNewID() !== end($all_courses)->getNewID()) {
                            ?>
                            <div id="mobileCourse_rightArrow">
                                <form method="post">
                                    <input type="hidden" name="newID"
                                           value="<?php echo $all_courses[$current_course_index + 1]->getNewID(); ?>">
                                    <input type="image" name="submit" alt="Submit" id="courseRightArrow"
                                           src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/Arrow-Right.png">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div> <!--end new course column-->

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

            </div> <!--end newCourse row-->

            <!--HEIGHT SPACER-->
            <div class="spacer"></div>


            <!--REPEATING COURSE ROW-->
            <div class="grid-x">

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

                <?php

                include_once WP_PLUGIN_DIR . '/cursusPlugin/includes/model/repeatingCourses.php';
                $repeatingCourses = new repeatingCourses();
                $all_courses = $repeatingCourses->getRepeatingCourseList();
                //shorthand if
                $current_id = $repeatingCourses->getPostValues()['newID'] ? $repeatingCourses->getPostValues()['newID'] : $all_courses[0]->getRepeatingID();
                $current_course = $repeatingCourses->getRepeatingCourseById($current_id);
                $current_course_index = null;
                ?>

                <!--REPEATING COURSE COLUMN-->
                <div class="newsColumn cell small-12 medium-10 large-10">

                    <!--REPEATING COURSES-->
                    <div id="upperCourseSlant"></div>
                    <div class="grid-x repeatingCourse">
                        <!--HEADER-->
                        <h4 class="repeatingCourse_header">Cursus Agenda</h4>
                        <!--REPEATING COURSE CONTENT-->
                        <div class="small-12 medium-12 large-12 cell">
                            <!--REPEATING COURSE LIST-->
                            <table id="courseList" cellspacing="0" cellpadding="0">
                                <?php
                                foreach ($all_courses as $obj) {
                                    ?>
                                    <tr id='courseListRow'>
                                        <td id='courseListTitle'>
                                            <p>
                                                <?= $obj->getTitle(); ?>
                                            </p>
                                        </td>
                                        <td id='repeatingCourseDate'>
                                            <p>
                                                <?= $obj->getDate(); ?>
                                            </p>
                                        </td>
                                        <td id='repeatingCourseRegistrations'>
                                            <p>
                                                <?php echo '?' . '/' . $obj->getMaxParticipants(); ?>
                                            </p>
                                        </td>
                                        <td id="repeatingCourseButtons">
                                            <button id='courseList_registerButton'
                                                    onclick="myFunction('registerRowContainer')">Inschrijven
                                            </button>
                                            <button id='courseList_infoButton' onclick="myFunction('Demo1')">Meer
                                                informatie
                                            </button>
                                        </td>
                                    </tr>
                                    <tr id="courseList_infoRow">
                                        <td colspan="4">
                                            <div id="Demo1" class="w3-hide">
                                                <p>
                                                    <?= $obj->getDescription(); ?>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="courseList_registerRow">
                                        <td colspan="4">
                                            <!--REGISTRATION-->
                                            <div id="registerRowContainer" class="w3-hide">
                                                <div class="grid-x newCourseRegister" id="registrationSection">
                                                    <div class="cell small-1 medium-1 large-1"></div>
                                                    <!--REGISTRATION FORM-->
                                                    <form class="newCourseForm small-10 medium-10 large-10 cell"
                                                          method="post">
                                                        <input type="hidden" name="repeatingID"
                                                               value="<?php echo $current_course->getRepeatingID(); ?>">
                                                        <div class="naamVeld">
                                                            <h6 class="newCourse_title">Naam</h6>
                                                            <input class="naamInput" name="name">
                                                        </div>
                                                        <div class="emailVeld">
                                                            <h6 class="newCourse_title">E-mail</h6>
                                                            <input class="emailInput" name="mail">
                                                        </div>
                                                        <div class="telVeld">
                                                            <h6 class="newCourse_title">Telefoonnummer</h6>
                                                            <input class="telInput" name="tel">
                                                        </div>
                                                        <div class="berichtVeld">
                                                            <h6 class="newCourse_title">Bericht</h6>
                                                            <textarea class="berichtInput" name="comment"></textarea>
                                                        </div>
                                                        <div class="courseType">
                                                            <input type="hidden" name="courseType"
                                                                   value="<?= $current_course->getRepeatingID() ?>">
                                                        </div>
                                                        <!--REGISTRATIONS & REGISTRATION SUBMIT-->
                                                        <div class="grid-x">
                                                            <div class="cell small-0 medium-2 large-10"></div>
                                                            <!--SUBMIT REGISTRATION-->
                                                            <div class="cell small-12 medium-4 large-2">
                                                                <a href="<?php //Submit ?>">
                                                                    <button type="button" name="add"
                                                                            class="newRegistrationSubmit">Inschrijven
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="cell small-1 medium-1 large-1"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>

                        </div>

                    </div>
                    <div id="lowerCourseSlant"></div>
                </div> <!--end new course column-->

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

            </div> <!--end repeating course row-->


        </main> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<!--HEIGHT SPACER-->
<div class="spacer"></div>

<!--FOOTER-->
<div class="show-for-large">
    <?php
    get_footer();
    ?>
</div>
