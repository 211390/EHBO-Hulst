<?php

/**
 * Created by PhpStorm.
 * User: Thijs van der Poel
 * Date: 18/11/2019
 */
/*
 * Template Name: EHBO Hulst Historie
 * Description: Deze template is voor uw Historie pagina.
 */
get_header();


?>
<!--CONTENT-->
<div class="content">

    <!--INNER CONTENT-->
    <div class="inner-content grid-x grid-margin-x grid-padding-x">

        <!--GRID SPACER SECTION-->
        <div class="small-1 medium-1 large-1 cell"></div>

        <!--MAIN GRID SECTION-->
        <main class="main small-10 medium-10 large-10 cell" role="main">

            <div class="spacer"></div>

            <!--LOAD PAGE CONTENT-->
            <h1>Historie</h1>

            <?php if (have_posts()) : while (have_posts()) : the_post();
                get_template_part('parts/loop', 'page');
            endwhile; endif; ?>

        </main> <!-- end #main -->

        <!--GRID SPACER SECTION-->
        <div class="small-1 medium-1 large-1 cell">
        </div>

    </div> <!-- end #inner-content -->

    <!--HEIGHT SPACER-->
    <div class="spacer"></div>

</div> <!-- end #content -->


<!--FOOTER-->
<div class="show-for-large">

    <div id="historyBottomLine"></div>

    <?php
    get_footer();
    ?>
</div>
