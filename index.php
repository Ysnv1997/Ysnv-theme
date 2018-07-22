<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:51:04
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-22 12:09:23
 */
get_header();?>
    <!-- 顶部栏拓展 -->
    <?php include 'expand/index/exhibition.php'; ?>
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


          <?php if(stayma('stayma_arttop_open')): ?>

              <!-- 特别推荐三个位子 -->
              <div class="row hidden-xs new-top">


                  <?php if(!empty(stayma('stayma_arttop_id1'))): ?>
                      <div class="col-md-4 col-sm-4">
                          <article class="new-top-rec">
                              <a href="<?php echo get_post(stayma('stayma_arttop_id1')) -> guid ?> ">
                                <div class="top-rec-img">
                                  <img src="<?php echo get_post_thumbnail_url(stayma('stayma_arttop_id1')); ?>" alt="">
                                  <div class="top-rec-info">
                                    <p class="top-rec-info-name">
                                    <?php
                                      echo wp_trim_words( get_post( stayma('stayma_arttop_id1') )->post_title, 20 );
                                      ?>
                                    </p>
                                    <span class="top-rec-info-category">
                                    <?php $the_post_category = get_the_category(get_the_ID());
                                    echo $the_post_category[0]->cat_name; ?>
                                    </span>
                                  </div>
                                </div>
                              </a>
                          </article>
                      </div>
                  <?php endif; ?>

                  <?php if(!empty(stayma('stayma_arttop_id2'))): ?>
                      <div class="col-md-4 col-sm-4">
                          <article class="new-top-rec">
                              <a href="<?php echo get_post(stayma('stayma_arttop_id2')) -> guid ?> ">
                                <div class="top-rec-img">
                                  <img src="<?php echo get_post_thumbnail_url(stayma('stayma_arttop_id2')); ?>" alt="">
                                  <div class="top-rec-info">
                                    <p class="top-rec-info-name">
                                    <?php
                                      echo wp_trim_words( get_post( stayma('stayma_arttop_id2') )->post_title, 20 );
                                      ?>
                                    </p>
                                    <span class="top-rec-info-category">
                                    <?php $the_post_category = get_the_category(get_the_ID());
                                    echo $the_post_category[0]->cat_name; ?>
                                    </span>
                                  </div>
                                </div>
                              </a>
                          </article>
                      </div>
                  <?php endif; ?>

                  <?php if(!empty(stayma('stayma_arttop_id3'))): ?>
                      <div class="col-md-4 col-sm-4">
                          <article class="new-top-rec">
                              <a href="<?php echo get_post(stayma('stayma_arttop_id3')) -> guid ?> ">
                                <div class="top-rec-img">
                                  <img src="<?php echo get_post_thumbnail_url(stayma('stayma_arttop_id3')); ?>" alt="">
                                  <div class="top-rec-info">
                                    <p class="top-rec-info-name">
                                    <?php
                                      echo wp_trim_words( get_post( stayma('stayma_arttop_id3') )->post_title, 20 );
                                      ?>
                                    </p>
                                    <span class="top-rec-info-category">
                                    <?php $the_post_category = get_the_category(get_the_ID());
                                    echo $the_post_category[0]->cat_name; ?>
                                    </span>
                                  </div>
                                </div>
                              </a>
                          </article>
                      </div>
                  <?php endif; ?>
              </div>
          <?php endif; ?>
          <!-- 首页挑选 -->
          <div class="row">

          </div>
              <!-- 首页文章列表 -->
            <div id="article-list">
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
              <article class="post">
                  <h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                  <div class="row post-lining">
                      <div class="col-sm-3 post-img-c">
                      <?php if (get_post_thumbnail_url($post -> id)): ?>
                        <a href="<?php the_permalink() ?>" style="background-image:url(<?php echo get_post_thumbnail_url($post -> id) ?>);"></a>
                      <?php else: ?>
                        <a href="<?php the_permalink() ?>" class="hidden-xs">
                          <div class="time">
                            <span class="post-day"><?php  the_time('j') ?></span>
                            <span class="post-ym"><?php  the_time('Y-n') ?></span>
                          </div>
                        </a>
                      <?php endif; ?>
                      </div>
                      <div class="post-text-c <?php echo !empty(get_post_thumbnail_url($post -> id)) ? 'col-sm-9' : 'post-noimg'?>">
                          <p><?php echo wp_trim_words( get_the_content(), 300 ); ?></p>
                          <div class="tags hidden-xs">
                              <?php the_tags('', '', '');?>
                              <div class="time">
                                  <i class="glyphicon glyphicon-time"></i> <?php  the_time('Y-n-j') ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </article>
              <?php endwhile; ?>
              <?php else : ?>
                  <h4>暂无内容，请稍后再来！</h4>
              <?php endif; ?>
            </div>
              <!-- 分页导航 -->
              <nav aria-label="...">
                <ul class="pager" id="page-nav">
                  <li class="previous"><?php previous_posts_link(__('上一页')) ?></li>
                  <li class="next"> <?php next_posts_link(__('下一页')) ?></li>
                </ul>
              </nav>
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