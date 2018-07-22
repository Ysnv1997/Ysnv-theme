<?php
function wpmee_comment($comment, $args, $depth) {
    global $post;
    $commentcountText='';
    $GLOBALS['comment'] = $comment;

?>
<li <?php comment_class($GLOBALS['wow_comments']); ?>  id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID() ?>">

        <div class="comment-avatar"><?php echo get_avatar( $comment ); ?></div>
        <div class="comment-body">
            <div class="comment_author">
                <span class="name"><?php comment_author_link() ?></span>
                <?php if($comment->user_id == 1) echo "<span class='label label-danger'>官方</span>"; ?>
                <?php echo get_author_class($comment->comment_author_email,$comment->user_id); ?>
                <em><?php echo get_comment_time('Y-m-d H:i') ?></em>
            </div>

            <div class="comment-text">
            <?php comment_text() ?>
            <?php if ( $comment->comment_approved == '0' ) : ?>
            <font style="color:#C00; font-style:inherit">您的评论正在等待审核中...</font>
            <?php endif; ?>
            </div>
            <div class="comment_reply">
                <span class="comment_reply_but">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => "回复"))) ?>
                </span>
            </div>
        </div>
    </div>
<?php }
function wpmee_end_comment() {
    echo '</li>';
}