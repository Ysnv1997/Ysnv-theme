<?php if(stayma('is_open_about')): ?>
<div class="sidebar-box sidebar-about-me">
    <h5 class="sidebar-header about">关于我 / About Me</h5>
    <div class="my-info">
        <img src="<?php echo stayma('about_img') ?>" alt="">
        <div class="my-info-text">
            <h5><?php echo stayma('about_name') ?></h5>
            <p><i class="glyphicon glyphicon-map-marker"></i> <?php echo stayma('about_where') ?></p>
        </div>
        <p><?php echo stayma('about_text') ?></p>
    </div>
    <div class="my-link">
        <ul class="side_me">
            <li><i class="glyphicon glyphicon-tag"></i> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('url'); ?></a></li>
            <li><i class="glyphicon glyphicon-time"></i> 本站已艰难的存活了<b> <?php echo floor((time()-strtotime(stayma('stayma_info_time')))/86400); ?></b> 天</li>
            <li><i class="glyphicon glyphicon-fire"></i> 本站一共<b><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?></b>篇博文 </li>
        </ul>
    </div>
    <div class="my-but">
        <a href="mailto:<?php echo stayma('about_email') ?>" class="my-but-a col-sm-5 pull-left" data-toggle="tooltip" data-placement="top" title="用邮件和我交流!">E-mail</a>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo stayma('about_qq') ?>&site=qq&menu=yes" class="my-but-a col-sm-5 pull-right" data-toggle="tooltip" data-placement="top" title="用QQ和我即时通讯!">即时通讯</a>
    </div>

</div>
<?php endif; ?>
<div class="sidebar-box sidebar-search">
  <div class="search-z">
    <form id="search" method="get" class="clearfix" action="<?php echo home_url( '/' ); ?>">
      <input type="text" class="form-control" id="inputSuccess5" aria-describedby="inputSuccess5Status" placeholder="输入关键词后回车" name="s">
    </form>
  </div>
</div>

<?php if (stayma('stayma_ggw_3text')): ?>
<div class="sidebar-box ggw3">
  <?php echo stayma('stayma_ggw_3text'); ?>
</div>
<?php endif ?>


<?php if(stayma('is_open_newart')): ?>
<div class="sidebar-box sidebar-new-art">
    <h5 class="sidebar-header">最新文章 / New Article</h5>
    <ul class="sidebar-new-art-list">
      <?php $post_query = new WP_Query('showposts=10');
      while ($post_query->have_posts()) : $post_query->the_post();
      $do_not_duplicate = $post->ID; ?>
      <li>
      <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
      </li>
      <?php endwhile;?>
    </ul>
</div>
<?php endif; ?>
<?php if(stayma('is_open_tags')): ?>
<div class="sidebar-box sidebar-tages">
    <h5 class="sidebar-header">标签列表 / Tags List</h5>
    <div class="tages">
        <?php wp_tag_cloud('smallest=12&largest=12&unit=px&number=100');?>
    </div>
</div>
<?php endif; ?>