<?php

/**
 * Created by PhpStorm.
 * User: Thijs van der Poel
 * Date: 18/11/2019
 */
/*
 * Template Name: EHBO Hulst Home
 * Description: Deze template is voor uw homepage
 */
get_header();


?>
<!--CONTENT-->
<div class="content">

    <!--INNER CONTENT-->
    <div class="inner-content grid-x grid-margin-x ">

        <!--MAIN GRID SECTION-->
        <main class="main small-12 medium-12 large-12 cell" role="main">

            <!--SLIDER-->
            <?php
            echo do_shortcode('[smartslider3 slider=2]');
            ?>

            <!--HEIGHT SPACER-->
            <div class="spacer"></div>

            <!--INFO ROW-->
            <div class="grid-x">

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

                <!--INFO COLUMN-->
                <div class="cell small-10 medium-10 large-10">
                    <h1>Over ons</h1>

                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        get_template_part('parts/loop', 'page');
                    endwhile; endif; ?>

                    <!--HEIGHT SPACER-->
                    <div class="spacer"></div>
                </div>

                <!--SPACER COLUMN-->
                <div class="cell small-1 medium-1 large-1">
                </div>

                <!--CONTENT-->
            </div>

            <!--POST ROW-->
            <div class="grid-x">

                <!--NEWS COLUMN-->
                <div class="newsColumn cell small-12 medium-12 large-8">
                    <?php

                    include_once('Constants.php');

                    //defining posts
                    $paged = array('posts_per_page' => Constants::POSTS_PER_PAGE, 'offset' => Constants::OFFSET, 'category_name' => 'nieuwsbericht', 'order' => 'desc');

                    if (get_query_var('paged')) {
                        $paged = get_query_var('paged');
                    } elseif (get_query_var('page')) {
                        $paged = get_query_var('page');
                    } else {
                        $paged = 1;
                    }

                    $the_query = new WP_Query('posts_per_page=2&paged=' . $paged);

                    $temp_query = $wp_query;
                    $wp_query = NULL;
                    $wp_query = $the_query;

                    if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                        ?>

                        <!--LOAD POSTS-->
                        <div id="upperPostSlant"></div>
                        <div class="grid-x newsPost">
                            <div class="small-12 medium-12 large-4 cell">
                                <div class="newsPost_img"><?php the_post_thumbnail(); ?></div>
                            </div>
                            <div class="small-12 medium-12 large-8 cell">
                                <div class="newsPost_container">
                                    <h4 class="newsPost_title"><?php the_title(); ?></h4>
                                    <div class="newsPost_text"><?php the_content(); ?></div>
                                    <a href="<?php echo(get_permalink()); ?>">
                                        <p class="newsPost_read_more">Meer lezen</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="lowerPostSlant"></div>

                    <?php endwhile;
                        wp_reset_postdata(); ?>

                        <!--ERROR MESSAGE-->
                    <?php else: ?>
                        <?php _e('Sorry, er ging iets mis met het laden van de berichten'); ?>
                    <?php endif; ?>

                    <!--PAGINATION-->
                    <div class="postPagination">
                        <div id="leftArrow">
                            <?php next_posts_link('<img id="leftArrow" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/Arrow-Left.png"
                            alt="Oudere berichten"/>');
                            ?>
                        </div>
                        <div id="rightArrow">
                            <?php previous_posts_link('<img id="rightArrow" src="http://localhost/ehbo-hulst/wp-content/uploads/2019/11/Arrow-Right.png" 
                            alt="Nieuwere berichten"/>');
                            ?>
                        </div>
                    </div>
                </div>

                <!--SOCIAL MEDIA COLUMN-->
                <div class="cell socialColumn small-12 medium-12 large-4">
                    <div id="upperSocialSlant"></div>
                    <div class="grid-x socialFeed">
                        <h5 class="socialHeader">Social Media</h5>
                        <!--FEED THEM SOCIAL PLUG-IN SHORTCODE-->
                        <?php
                        echo do_shortcode('[fts_facebook type=page id=183362285059359 access_token=EAAP9hArvboQBAPaqaD7332ucqGnWIg91fokgZArsW0CZBq8e7AbNtMleoYeVbYwmLvZAd1ZC5kpgB73yISkuomZBzW3ZAgZBeoGWf22R2PvScIr1AgQrzmhtix23RkJxZBz7VYraS3BRdZCiwhFxjncbLheWI31gsjmFIXDZCYGBftIZCnpLVCxoUqr posts=2 description=no posts_displayed=page_only]');
                        echo do_shortcode('[fts_instagram instagram_id=14351948115 access_token=14351948115.da06fb6.b89f9a8195a843f8a8d1c4eff856a547 pics_count=4 type=user profile_wrap=no super_gallery=yes columns=3 force_columns=no space_between_photos=1px icon_size=65px hide_date_likes_comments=no]');
                        ?>
                    </div>
                    <div id="lowerSocialSlant"></div>
                </div>

            </div>
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
