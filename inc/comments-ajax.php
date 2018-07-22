<?php
if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}
require_once(dirname(__FILE__)."/../../../../wp-load.php");
nocache_headers();
$comment_post_ID = (int) $_POST['comment_post_ID'];
$status = $wpdb->get_row( $wpdb->prepare("SELECT post_status, comment_status FROM $wpdb->posts WHERE ID = %d", $comment_post_ID) );
function err($ErrMsg) {
    header('HTTP/1.0 500 Internal Server Error');
    echo $ErrMsg;
    exit;
}
if ( empty($status->comment_status) ) {
	do_action('comment_id_not_found', $comment_post_ID);
    err(__('您试图评论的帖子目前不存在于数据库中。'));
} elseif ( !comments_open($comment_post_ID) ) {
	do_action('comment_closed', $comment_post_ID);
    err(__('Sorry, 该帖子已经关闭评论.'));
} elseif ( in_array($status->post_status, array('draft', 'pending') ) ) {
	do_action('comment_on_draft', $comment_post_ID);
    err(__('The post you are trying to comment on has not been published.'));
} else {
	do_action('pre_comment_on_post', $comment_post_ID);
}
$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
$edit_id				      = ( isset($_POST['edit_id']) ) ? trim($_POST['edit_id']) : null;
$user = wp_get_current_user();
if ( $user->ID ) {
	if ( empty( $user->display_name ) )
		$user->display_name=$user->user_login;
	$comment_author       = $wpdb->escape($user->display_name);
	$comment_author_email = $wpdb->escape($user->user_email);
	$comment_author_url   = $wpdb->escape($user->user_url);
	if ( current_user_can('unfiltered_html') ) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters();
			kses_init_filters();
		}
	}
} else {
	if ( get_option('comment_registration') || 'private' == $status->post_status )
		err(__('Sorry, 请登录后发言'));
}
$comment_type = '';

if ( get_option('require_name_email') && !$user->ID ) {
	if ( 6 > strlen($comment_author_email) || '' == $comment_author )
        err( __('请填写必须要填的姓名和邮箱'));
	elseif ( !is_email($comment_author_email))
        err(__('请输入邮箱地址！'));
}
if ( '' == $comment_content )
    err(__('错误：请输入评论内容'));

$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
if ( $wpdb->get_var($dupe) ) {
    err(__('老铁！这条评论你已经说过了！'));
}
if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
$time_lastcomment = mysql2date('U', $lasttime, false);
$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
if ( $flood_die ) {
    err(__('抱歉，您留言的速度太快了！请稍后再来！'));
	}
}
$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

$comment_id = wp_new_comment( $commentdata );
$comment = get_comment($comment_id);
if ( !$user->ID ) {
	$comment_cookie_lifetime = apply_filters('comment_cookie_lifetime', 30000000);
	setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
	setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + $comment_cookie_lifetime, COOKIEPATH, COOKIE_DOMAIN);
}
$comment_depth = 1;
$tmp_c = $comment;
while($tmp_c->comment_parent != 0){
$comment_depth++;
$tmp_c = get_comment($tmp_c->comment_parent);
}
?>
   <li class="comment" id="li-comment-<?php comment_ID(); ?>" style="list-style: none;">
   <div class="comment-<?php comment_ID(); ?>">
      <div class="media comment-body" id="comment-<?php comment_ID(); ?>">
        <div class="media-left">
            <?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar( $comment, 48 ); } ?>
        </div>
        <div class="media-body">
          <?php printf(__('<p class="author_name">%s 说：</p>'), get_comment_author_link()); ?>
            <?php if ($comment->comment_approved == '0') : ?>
                <em>评论等待审核...</em><br />
        <?php endif; ?>
        <?php comment_text(); ?>
        </div>
      </div>
      <div class="comment-metadata">
        <span class="comment-pub-time">
          <?php echo get_comment_time('Y-m-d H:i'); ?>
        </span>
      </div>
</div>