<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:52:39
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-21 12:30:02
 */
?>
    <!-- 页尾 -->
    <footer>
        <div class="foot container-fluid">
          <div class="container">
            <div class="row footer">
              <div class="foot-about col-xs-12 col-md-6 col-lg-7">
                <div class="footer-about">
                  <h3 class="footer-title">网站声明</h3>
                  <p class="footer-txt-1"><?php echo stayma('footer_text') ?></p>
<!--                   <p class="footer-txt-2">新手教程：
                    <a href="" target="_blank">https://www.baidu.com</a>常用软件：
                    <a href="" class="last" target="_blank">https://stayma.cn</a>
                    </p> -->
                  <p class="footer-txt-3">
                  <?php if(!empty(stayma('footer_logo'))): ?>
                    <img src="<?php echo stayma('footer_logo'); ?>"></p>
                  <?php endif; ?>
                  <p class="footer-txt-4">
                    <a href="" target="_blank" rel="external nofollow"><?php echo stayma('stayma_index_icp'); ?></a></p>
                </div>
              </div>
              <div class="foot-cloud col-md-6 col-lg-5 visible-lg-inline visible-md-inline">
                <div class="tag-cloud footer-banner">
                  <h3 class="footer-title">最新反馈</h3>
                  <ul>
                    <?php
        $limit = $limit ? $limit : 8;
        $outpost = $outpost ? $outpost : 0;
        $outer = $outer ? $outer : 1;
        $output='';
        global $wpdb;
          $sql = "SELECT DISTINCT ID, comment_ID, comment_post_ID, SUBSTRING(comment_content,1,40) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_post_ID!='".$outpost."' AND user_id!='".$outer."' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $limit";
          $comments = $wpdb->get_results($sql);
        foreach ($comments as $comment) {
        $output .='<li><a href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'">'.$comment->com_excerpt.'</a></li>';
      }
        $output = convert_smilies($output);
        echo $output;
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
    </footer>
    <div class="goTop hidden-xs hidden-sm">
      <img src="<?php bloginfo('template_url'); ?>/images/top.png" alt="">
    </div>
    <?php wp_footer();?>
  <div style="display: none;">
    <?php echo stayma('stayma_javascript'); ?>
  </div>
  </body>
</html>