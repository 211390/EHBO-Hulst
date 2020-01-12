<?php
/**
  *	Description	of	view_shortcodes.php
  *
  *	@author	CvanderEnde
  */

// Add the stylguide from shortcode
add_shortcode('ivs_stylguide_form', 'load_form_view');

// add the styleguide slider shortcode
add_shortcode('ivs_image_slider', 'load_image_slider');

// creates the function for galerij
function load_gallery_view( $atts, $content = NULL) {
 // Include the galerij view
include CURSUS_PLUGIN_INCLUDES_VIEWS_DIR. '/gallery.php';

}

// creates the function for the from
function load_form_view( $atts, $content = NULL) {
 // Include the form view
include CURSUS_PLUGIN_INCLUDES_VIEWS_DIR. '/newCourseForm.php';

}

// creates the function for the slider
function load_image_slider( $atts, $content = NULL) {
 // Include the slider view
include CURSUS_PLUGIN_INCLUDES_VIEWS_DIR. '/image_slider.php';

}

// slider option's shortcodes

// // add the styleguide slider shortcode
// add_shortcode('ivs_slider_menu', 'load_slider_menu');
//
// // creates the function for galerij
// function load_slider_menu( $atts, $content = NULL) {
//  // Include the galerij view
// $ivs_menu_slider = true;
// echo "this is the menu";
//
// }
//
// // add the styleguide slider shortcode
// add_shortcode('ivs_slider_form', 'load_slider_form');
//
// // creates the function for galerij
// function load_slider_form( $atts, $content = NULL) {
//  // Include the galerij view
// $ivs_form_slider = true;
// echo "this is the form";
//
// }
