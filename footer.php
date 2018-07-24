<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:52:39
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-24 18:45:22
 */
?>
  <footer class="footer">
  <span class="glyphicon glyphicon-adjust hidden-xs" id="footer-hidden-open" data-open="false"></span>

    <div class="container hidden-footer-list hidden-xs">
        <div class="row">
          <div class="col-md-3 col-sm-4 hidden-xs footer-introduction">
            <p class="footer-name">网站简介</p>
            <p class="footer-info-text"><?php echo stayma('footer_text'); ?></p>
          </div>
          <div class="col-md-3 col-sm-4 footer-aboutWeb">
            <p class="footer-name">最新留言</p>
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
          <div class="col-md-5 col-sm-4 col-ms-offset-1 footer-icon">
              <ul>
                <?php if(!empty(stayma('social_weibo'))): ?>
                  <li><a href="<?php echo stayma('social_weibo')?>"><img src="<?php bloginfo('template_url'); ?>/images/weibo.png" alt="" /></a></li>
                <?php endif; ?>
                <?php if(!empty(stayma('social_github'))): ?>
                  <li><a href="<?php echo stayma('social_github')?>"><img src="<?php bloginfo('template_url'); ?>/images/github.png" alt="" /></a></li>
                <?php endif; ?>
                <?php if(!empty(stayma('social_twitter'))): ?>
                  <li><a href="<?php echo stayma('social_twitter')?>"><img src="<?php bloginfo('template_url'); ?>/images/twitter.png" alt="" /></a></li>
                <?php endif; ?>
              </ul>
              <div class="footer-icon-diy">
                  <?php echo stayma('footer_diy'); ?>
              </div>
          </div>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>Copyright © 2016 - 2018 <?php echo stayma('stayma_info_title') ?> - StayMa.Cn / 版本 V 1.0 <?php echo stayma('stayma_index_icp') ?></p>
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