<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 14:40:50
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-23 14:35:35
 */
add_filter('pre_option_link_manager_enabled','__return_true');
// 屏蔽WordPress默认小工具
add_action( 'widgets_init', 'my_unregister_widgets' );
function my_unregister_widgets() {
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Search' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Nav_Menu_Widget' );

}
/* 评论作者链接新窗口打开 */
function specs_comment_author_link() {
    $url    = get_comment_author_url();
    $author = get_comment_author();
    if ( empty( $url ) || 'http://' == $url )
        return $author;
    else
        return "<a target='_blank' href='$url' rel='external nofollow' class='url'>$author</a>";
}
add_filter('get_comment_author_link', 'specs_comment_author_link');
//字数统计功能
function count_words($text) {
    global $post;
    if ('' == $text) {
        $text = $post->post_content;
        if (mb_strlen($output, 'UTF-8') < mb_strlen($text, 'UTF-8')) $output.= mb_strlen(preg_replace('/\s/', '', html_entity_decode(strip_tags($post->post_content))) , 'UTF-8');
        return $output;
    }
}
// 回复评论添加@
function idevs_comment_add_at($comment_text, $comment = '') {
    if ($comment->comment_parent > 0) {
        $comment_text = '<span id="AtName"> @ </span><a id="AtName" href="#comment-' . $comment->comment_parent . '">' . get_comment_author($comment->comment_parent) . '</a>: ' . $comment_text;
    }
    return $comment_text;
}
add_filter('comment_text', 'idevs_comment_add_at', 20, 2);
// 评论后可见
function reply_to_read($atts, $content = null) {
    extract(shortcode_atts(array(
        "notice" => '<blockquote><center><p class="reply-to-read"">注意：本段内容须成功“<a href="' . get_permalink() . '#respond" title="回复本文">回复本文</a>”后“<a href="javascript:window.location.reload();" title="刷新本页">刷新本页</a>”方可查看！</p></center></blockquote>'
    ) , $atts));
    $email = null;
    $user_ID = (int)wp_get_current_user()->ID;
    if ($user_ID > 0) {
        $email = get_userdata($user_ID)->user_email;
        //对博主直接显示内容
        $admin_email = 'ysnv1997@163.com'; //博主Email
        if ($email == $admin_email) {
            return $content;
        }
    } else if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
        $email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);
    } else {
        return $notice;
    }
    if (empty($email)) {
        return $notice;
    }
    global $wpdb;
    $post_id = get_the_ID();
    $query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
    if ($wpdb->get_results($query)) {
        return do_shortcode($content);
    } else {
        return $notice;
    }
}
add_shortcode('reply', 'reply_to_read');
//postviews
function get_post_views($post_id) {
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        $count = '0';
    }
    echo number_format_i18n($count);
}
function set_post_views() {
    global $post;
    $post_id = $post->ID;
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if (is_single() || is_page()) {
        if ($count == '') {
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, '0');
        } else {
            update_post_meta($post_id, $count_key, $count + 1);
        }
    }
}
add_action('get_header', 'set_post_views');
// 获取特色图
function get_post_thumbnail_url($post_id){
    $post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
    $post=get_post($post_id);
    if( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $post_thumbnail_src = $thumbnail_src [0];
    } else {
        $post_thumbnail_src = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        if(!empty($matches[1][0])){
            $post_thumbnail_src = $matches[1][0];   //获取该图片 src
        }else{
            $post_thumbnail_src = '';
        }
    }
    return $post_thumbnail_src;
}
// 邮件通知
function sirius_comment_approved($comment) {
    if(is_email($comment->comment_author_email)) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim($comment->comment_author_email);
        $post_link = get_permalink($comment->comment_post_ID);
        $subject = '[通知]您在[STAYMA博客]的留言已经通过审核';
        $message = '
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #FFF;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">Hi ' . trim($comment->comment_author) . ':</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">您有一条留言通过了管理员的审核并显示在文章页面，摘要信息请见下表。</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="280px;">文章</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="270px;">内容</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="110px;" >操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">《' . get_the_title($comment->comment_post_ID) . '》</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'. trim($comment->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.get_comment_link( $comment->comment_ID ).'" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">查看留言</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">' . date("Y年m月d日",time()) . '</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"" . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
}
function comment_mail_notify($comment_id) {
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '[通知]您[STAYMA博客]的留言有了新的回复';
        $message = '
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #FFF;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">Hi ' . trim(get_comment($parent_id)->comment_author) . ':</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">您有一条留言有了新的回复，摘要信息请见下表。</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">原文</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">回复</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="100px;">作者</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="90px;" >操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim(get_comment($parent_id)->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'. trim($comment->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim($comment->comment_author) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.get_comment_link( $comment->comment_ID ).'" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">查看回复</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">' . date("Y年m月d日",time()) . '</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"" . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
}
add_action('comment_post', 'comment_mail_notify');
//私密评论
function liao_private_message_hook( $comment_content , $comment){
    $comment_ID = $comment->comment_ID;
    $parent_ID = $comment->comment_parent;
    $parent_email = get_comment_author_email($parent_ID);
    $is_private = get_comment_meta($comment_ID,'_private',true);
    $email = $comment->comment_author_email;
    $current_commenter = wp_get_current_commenter();
    if ( $is_private ) $comment_content = '#私密# ' . $comment_content;
    if ( $current_commenter['comment_author_email'] == $email || $parent_email == $current_commenter['comment_author_email'] || current_user_can('delete_user') ) return $comment_content;
    if ( $is_private ) return '<span style="color:#A6A6A6"><i class="fa fa-lock fa-fw"></i>该评论为私密评论</span>';
    return $comment_content;
}
add_filter('get_comment_text','liao_private_message_hook',10,2);
function liao_mark_private_message( $comment_id ){
    if ( $_POST['is-private'] ) {
        add_comment_meta($comment_id,'_private','true');
    }
}
add_action('comment_post', 'liao_mark_private_message');
/**
 * WordPress 添加评论之星
 * https://www.wpdaxue.com/wp-comments-vip.html
 */
function get_author_class($comment_author_email,$user_id){
    global $wpdb;
    $author_count = count($wpdb->get_results(
    "SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
    /*如果不需要管理员显示VIP标签，就把下面一行的 // 去掉*/
    $adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;
    if($author_count>=1 && $author_count<20)
        echo '<span class="label label-default">LV.1</span>';
    else if($author_count>=20 && $author_count<40)
        echo '<span class="label label-primary">LV.2</span>';
    else if($author_count>=40 && $author_count<80)
        echo '<span class="label label-success">LV.3</span>';
    else if($author_count>=80 && $author_count<160)
        echo '<span class="label label-info">LV.4</span>';
    else if($author_count>=160 && $author_count<320)
        echo '<span class="label label-warning">LV.5</span>';
    else if($author_count>=320 && $author_count<640)
        echo '<span class="label label-danger">LV.6</span>';
    else if($author_count>=640)
        echo '<span class="comment_admin">LV.7</span>';
}
// WordPress 文章内调用文章
function xx_insert_posts($atts, $content = null) {
    extract(shortcode_atts(array(
        'ids' => ''
    ) , $atts));
    global $post;
    $content = '';
    $postids = explode(',', $ids);
    $inset_posts = get_posts(array(
        'post__in' => $postids
    ));
    foreach ($inset_posts as $key => $post) {
        setup_postdata($post);
        $content.= '<div class="wp-embed-post"><a target="_blank" href="' . get_permalink() . '">';
        if (get_post_thumbnail_url($post->ID)) {
            $content.= '<div class="wp-embed-img"><img src="' . get_post_thumbnail_url($post->ID) . '" alt=""></div>';
        };
        $content.= '<div class="wp-embed-content"><div><p class="wp-embed-post-heading">' . wp_trim_words(get_the_title() , 22) . '
            </p>
            <div class="wp-embed-post-excerpt">' . wp_trim_words(get_the_content() , 100, '...') . '</div>
        </div>
      </div>
    </a>
</div>';
    }
    wp_reset_postdata();
    return $content;
}
add_shortcode('stayma_get_post', 'xx_insert_posts');
//添加HTML编辑器自定义快捷标签按钮
add_action('after_wp_tiny_mce', 'add_button_mce');
function add_button_mce($mce_settings) {
?>
<script type="text/javascript">
    QTags.addButton( 'hr', 'hr', "\n<hr />\n", "" );
    QTags.addButton( 'quote', '引用文章', "\n[stayma_get_post ids=??????]\n", "" );
    QTags.addButton( 'd-html', 'HTML高亮', "\n<pre class=\"line-numbers language-html\"><code class=\"language-html\">", "</code></pre>\n" );
    QTags.addButton( 'd-css', 'CSS高亮', "\n<pre class=\"line-numbers language-css\"><code class=\"language-css\">", "</code></pre>\n" );
    QTags.addButton( 'd-javascript', 'javascript高亮', "\n<pre class=\"line-numbers language-javascript\"><code class=\"language-javascript\">", "</code></pre>\n" );
    QTags.addButton( 'd-php', 'php高亮', "\n<pre class=\"line-numbers language-php\"><code class=\"language-php\">", "</code></pre>\n" );
    QTags.addButton( 'commLook', '评论后可见', "[reply]", "[/reply]\n" );
</script>
<?php }; ?>
<?php
//友情链接
function get_the_link_items($id = null){
    $bookmarks = get_bookmarks('orderby=date&category=' .$id );
    $output = '';
    if ( !empty($bookmarks) ) {
        $output .= '<ul class="link-items fontSmooth">';
        foreach ($bookmarks as $bookmark)
        {
            $output .=  '<li class="link-item"><a class="link-item-inner effect-apollo" href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" rel="' . $bookmark->link_rel . '" >';

            if(($bookmark->link_notes)){
                $output .= get_avatar($bookmark->link_notes,64);
            }else if($bookmark->link_image){

                $output .= '<img alt="' . $bookmark->link_description . '" src="'. $bookmark->link_image .'" title="' . $bookmark->link_description . '">';

            }
            else{

                $output .= '<img alt="' . $bookmark->link_description . '" src="'.get_template_directory_uri().'/img/avatar.png" title="' . $bookmark->link_description . '">';

            }

            $output .= '<span class="sitename">'. $bookmark->link_name .'</span></a></li>';
        }
        $output .= '</ul><div class="clearfix"></div>';
    }
    return $output;
}

function get_link_items(){
    $linkcats = get_terms( 'link_category' );
    if ( !empty($linkcats) ) {
        foreach( $linkcats as $linkcat){
                if( $linkcat->description ) $linkdes .= '- <span class="link-description">' . $linkcat->description . '</span>';
            $result .=  '<div class="link-title"><span>'.$linkcat->name.'</span>'.$linkdes.'</div>';

            $result .=  get_the_link_items($linkcat->term_id);
        }
    } else {
        $result = get_the_link_items();
    }
    return $result;
}