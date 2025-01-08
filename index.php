<?php
/*
Plugin Name: Category Plugin
Description: A simple plugin to display categories using a shortcode.
Version: 1.0
Author: Luceq
*/

// Function to display categories
function display_categories() {
    $categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'number' => 6, // Set the maximum number of categories to display
    ));

    if (!empty($categories) && !is_wp_error($categories)) {
        $output = '<ul class="category__list__plugin">';
        foreach ($categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image_url = wp_get_attachment_url($thumbnail_id);
        $output .= '<li class="li__category__box">';
        $output .= '<a href="' . esc_url(get_term_link($category)) . '" class="category__link" style="background-image: url(' . esc_url($image_url) . ');">';
        $output .= '<span class="category__name">' . esc_html($category->name) . '</span>';
        $output .= '</a>';
        $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    } else {
        return 'No categories found.';
    }
}

// Enqueue styles
function category_plugin_styles() {
    wp_enqueue_style('category-plugin-styles', plugins_url('style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'category_plugin_styles');

// Register shortcode
function register_category_shortcode() {
    add_shortcode('category_list', 'display_categories');
}
add_action('init', 'register_category_shortcode');
