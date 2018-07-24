<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:51:04
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-24 18:20:19
 */
get_header();?>
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
<?php
    get_footer();
?>