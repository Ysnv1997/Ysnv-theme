<?php
    /**
     Template Name:单栏页面
     */
get_header();?>
<?php if(!empty(stayma('stayma_ggw_1img'))): ?>
    <!-- 广告位1 -->
    <div class="container ggw1 hidden-xs">
        <a target="_blank" href="<?php echo stayma('stayma_ggw_1text'); ?>">
        <img src="<?php echo stayma('stayma_ggw_1img'); ?>" alt="">
        </a>
    </div>
<?php endif; ?>
    <!-- 主体内容开始 -->
    <div class="container" id="container-box">
      <div class="row">
        <!-- 右边 -->
        <div class="blog-main col-sm-12 col-md-12">
        <?php if( have_posts() ){ the_post();?>
          <article class="article">
            <header class="article-header">
              <h1><?php the_title(); ?></h1>
              <small>
                <div class="article-time">
                  <i class="glyphicon glyphicon-time"></i> <?php  the_time('Y年n月j日') ?>
                </div>
                <div class="article-view">
                  <i class="glyphicon glyphicon-eye-open"></i> <?php get_post_views($post->ID); ?>
                </div>
                <div class="article-comment">
                  <i class="glyphicon glyphicon-fire"></i> <?php  echo get_comments_number();?>条评论
                </div>
              </small>
            </header>
            <article class="article-text">
              <?php the_content(); ?>
            </article>
          </article>
          <?php };?>
          <div class="comment-box">
            <?php comments_template(); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- 广告位2 -->
    <div class="container-fluid hidden-xs ggw2">
      <?php if(!empty(stayma('stayma_ggw_2img'))): ?>
      <div class="container">
        <a href="<?php echo stayma('stayma_ggw_2text'); ?>" target="_blank" rel="external nofloow">
          <img src="<?php echo stayma('stayma_ggw_2img'); ?>"></a>
      </div>
       <?php endif; ?>
    </div>

<?php
    get_footer();
?>