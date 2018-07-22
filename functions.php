<?php
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
require_once dirname(__FILE__) . '/inc/options-framework.php';
$optionsfile = locate_template('options.php');
load_template($optionsfile);
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#example_showhidden').click(function() {
        jQuery('#section-example_text_hidden').fadeToggle(400);
    });
    if (jQuery('#example_showhidden:checked').val() !== undefined) {
        jQuery('#section-example_text_hidden').show();
    }
});
</script>
<?php
}
add_action('optionsframework_after', 'show_category', 100);
function show_category() {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request.= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request.= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request.= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    echo '<div class="uk-panel uk-panel-box" style="margin-bottom: 20px;"><h3 style="margin-top: 0; margin-bottom: 15px; font-size: 18px; line-height: 24px; font-weight: 400; text-transform: none; color: #666;">可能会用到的分类ID</h3>';
    echo "<ul>";
    foreach ($categorys as $category) {
        echo '<li style="margin-right: 10px;float:left;">' . $category->name . "（<code>" . $category->term_id . '</code>）</li>';
    }
    echo "</ul></div>";
}
register_nav_menus( array(
    'one'    => '顶部左边主菜单',
    'two' => '顶部右边菜单'
) );
add_action( 'wp_enqueue_scripts', 'SuStatic' );
function SuStatic() {
    wp_register_script( 'swiper', get_template_directory_uri() . '/js/swiper.jquery.js', array(), true );
    wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), true );
    wp_register_script( 'ajax-comment', get_template_directory_uri() . '/ajax-comment/ajax-comment.js', array(), true );
    wp_register_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.js', array(), true );
    wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array(), true );
    if ( !is_admin() ) {
        wp_enqueue_script( 'bootstrap' );
        wp_enqueue_script( 'ajax-comment' );
        wp_enqueue_script( 'lightbox' );
        wp_enqueue_script( 'swiper' );
        wp_enqueue_script( 'main' );
    }
    wp_localize_script( 'ajax-comment', 'stayma_url',
        array(
            "url_ajax"      => admin_url("admin-ajax.php")
        )
    );
}
//检测主题更新
require 'expand/update.php';
$example_update_checker = new ThemeUpdateChecker(
    'Ysnv',
    'http://update.stayma.cn/ysnv-update/ysnv-update.json'
);
include 'ajax-comment/do.php';
include 'expand/comment.func.php';
include 'expand/nav.class.php';
include 'expand/func.func.php';