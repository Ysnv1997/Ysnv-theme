<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:51:04
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-20 22:04:31
 */
get_header();?>
    <!-- 顶部栏拓展 -->
<!--     <div class="intr-header" style="background-image:url(<?php echo stayma('stayma_xxinfo_img') ?>)">
            <div class="container">
                <div class="row intr-header-info">
                    <div>
                        <h3><?php echo stayma('stayma_xxinfo_text1') ?></h3>
                        <p><?php echo stayma('stayma_xxinfo_text2') ?></p>
                    </div>
                </div>
            </div>
    </div> -->


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
        <div class="blog-main col-sm-12 col-md-8">
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

        <!-- 左边侧边栏 -->
        <div class="blog-sidebar hidden-sm col-md-4 hidden-xs">
            <?php get_sidebar(); ?>
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