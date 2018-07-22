<?php
/**
 * @Author: Marte
 * @Date:   2018-07-19 13:51:21
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-22 13:42:50
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (is_home()) {
          bloginfo('name');
          echo " - ";
          bloginfo('description');
        } elseif (is_category()) {
          single_cat_title();
          echo " - ";
          bloginfo('name');
        } elseif (is_single() || is_page()) {
          single_post_title();
          echo " - ";
          bloginfo('description');
        } elseif (is_404()) {
          echo '页面未找到!';
          echo " - ";
          bloginfo('description');
        } else {
          wp_title('', true);
          echo " - ";
          bloginfo('description');
        }?>
    </title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/swiper.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/flat-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/lightbox.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/style.css">
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
    <meta name="description" content="<?php echo stayma('stayma_info_description'); ?>" />
    <meta name="keywords" content="<?php echo stayma('stayma_info_keywords'); ?>" />
    <style type="text/css"><?php echo stayma('stayma_css'); ?></style>
    <?php wp_head(); ?>
  </head>
  <body>
    <!-- 导航 -->
    <header>
        <nav class="navbar navbar-default navbar-static-top blog-header-top">
         <div class="container">
          <div class="navbar-header">
           <a class="navbar-brand blog-name" href="<?php bloginfo('url'); ?>"><?php echo stayma('stayma_info_title') ?></a>
           <a class="nav-top hidden-sm hidden-lg hidden-md" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" href="#"><span class="glyphicon glyphicon-tasks"></span></a>
           <a class="search-top hidden-sm hidden-lg hidden-md"><span class="glyphicon glyphicon-search" id="search" data-open="no"></span></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <?php if ( has_nav_menu( 'one' ) ) :
                wp_nav_menu( array(
                     'theme_location' => 'one',
                      'depth'             => 0,
                      'container'         => '',
                      'container_class'   => '',
                      'menu_class'        => 'super',
                      'items_wrap'        => '<ul class="nav navbar-nav">%3$s</ul>',
                      'walker' => new Header_Menu_Walker() ) );
            endif; ?>
           <ul class="nav navbar-nav2 navbar-nav navbar-right hidden-sm">
            <?php if ( has_nav_menu( 'two' ) ) :
                wp_nav_menu( array(
                     'theme_location' => 'two',
                     'container' => 'false',
                     'items_wrap' => '%3$s',
                     'walker' => new Header_Menu_Walker()
                ) );
            endif; ?>
           </ul>
          </div>
         </div>
        </nav>
    </header>
    <div class="search-s visible-xs-block">
      <div class="search-con">
    <form id="search" method="get" class="clearfix" action="<?php echo home_url( '/' ); ?>">
      <input type="text" class="form-control" id="inputSuccess5" aria-describedby="inputSuccess5Status" placeholder="输入关键词后回车" name="s">
    </form>
      </div>
    </div>