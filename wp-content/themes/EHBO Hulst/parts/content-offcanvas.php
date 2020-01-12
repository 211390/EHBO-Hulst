<?php
/**
 * The template part for displaying offcanvas content
 *
 * For more info: http://jointswp.com/docs/off-canvas-menu/
 */
?>

<!--OFF-CANVAS-->
<div class="off-canvas position-right" id="off-canvas" data-off-canvas>

    <!--INNER SIDEBAR CONTENT-->
    <div id="sidebarContainer">

        <!--MAIN NAVIGATION-->
        <div id="sidebarNav" class="small-12 medium-12 large-12 cell">
            <nav role="navigation">
                <?php joints_top_nav(); ?>
            </nav>
        </div>

        <!--WIDGETS-->
        <div class="small-12 medium-12 large-12 cell">
            <div class="grid-x secondary">
                <div class="cell footer-widget large-3" id="footer-sidebar2">
                    <?php
                    if (is_active_sidebar('footer-sidebar-2')) {
                        dynamic_sidebar('footer-sidebar-2');
                    }
                    ?>
                </div>
                <div class="cell footer-widget large-3" id="footer-sidebar3">
                    <?php
                    if (is_active_sidebar('footer-sidebar-3')) {
                        dynamic_sidebar('footer-sidebar-3');
                    }
                    ?>
                </div>
                <div class="cell footer-widget large-3" id="footer-sidebar4">
                    <?php
                    if (is_active_sidebar('footer-sidebar-4')) {
                        dynamic_sidebar('footer-sidebar-4');
                    }
                    ?>
                </div>
            </div>

            <!--COPYRIGHT-->
            <p class="source-org copyright text-white text-center" style="margin: 2%;">
                <small><!--&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>--> &copy; Realisatie door: <br/>
                    Stichting Innovision Solutions
                </small>
            </p>

        </div> <!--end #widgets-->
    </div> <!--end #inner sidebar content-->

    <!--LOAD JOINTSWP SIDEBAR FUNCTIONS-->
    <?php joints_off_canvas_nav();
    if (is_active_sidebar('offcanvas')) :
        dynamic_sidebar('offcanvas');
    endif; ?>

</div> <!--end #off-canvas-->
