<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function optionsframework_option_name() {
	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
function optionsframework_options() {

// 将所有页面（pages）加入数组
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = '选择页面：';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
	// Pull all the cateries into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	$options_metainfo = array(
		'author' => '作者',
		'cat' => '分类',
		'time' => '时间',
		'view' => '浏览量',
		'like' => '喜欢'
	);

	$wp_editor_settings = array(
		'wpautop' => true, // 默认
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	$topslide_array = array(
		'DESC' => __('默认排序'),
		'date' => __('时间排序'),
		'rand' => __('随机排序')
	);
	$avatar_array = array(
		'one' => 'WP默认',
		'two' => 'V2EX',
	);

	$index3_array = array(
		'one' => '显示分类',
		'two' => '显示顶置文章',
		'three' => '关闭',
	);


    $options_links = array();
    $options_links_obj = get_terms( 'link_category' );
    foreach ($options_links_obj as $link) {
        $options_links[$link->term_id] = $link->name;
    }

	$imagepath =  get_template_directory_uri() . '/img/themestyle/';

	$options = array();

	/*****基本设置*****/
	$options[] = array(
		'name' => __('基本设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('网站标题'),
		'desc' => __('请设置网站标题'),
		'id' => 'stayma_info_title',
		'type' => 'text');

	$options[] = array(
		'name' => __('网站关键字'),
		'desc' => __('请设置关键字，建议6-10个，请用英文逗号,隔开！'),
		'id' => 'stayma_info_keywords',
		'type' => 'text');

	$options[] = array(
		'name' => __('网站描述信息'),
		'desc' => __('请设置描述信息，建议80-100字。'),
		'id' => 'stayma_info_description',
		'type' => 'text');

	$options[] = array(
		'name' => __('备案号'),
		'desc' => __('请设置首页首屏较小文字信息。'),
		'id' => 'stayma_index_icp',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __('建站时间'),
		'desc' => __('请设置建站日期，格式为：2018-5-2'),
		'id' => 'stayma_info_time',
		'class' => 'mini',
		'type' => 'text');
	$options[] = array(
		'name' => __('首页设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('信息展示区图片'),
		'desc' => __('请上传信息展示区背景图片'),
		'id' => 'stayma_xxinfo_img',
		'type' => 'upload');

	$options[] = array(
		'name' => __('信息展示区文字1'),
		'desc' => __('请设置展示区文字1'),
		'id' => 'stayma_xxinfo_text1',
		'type' => 'text');

	$options[] = array(
		'name' => __('信息展示区文字2'),
		'desc' => __('请设置展示区文字2'),
		'id' => 'stayma_xxinfo_text2',
		'type' => 'text');


	$options[] = array(
		'name' => '是否开启特别置顶文章',
		'id' => 'stayma_arttop_open',
		'std' => true,
		'desc' => __('开启后，启动特别文章推荐'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('特别推荐文章1 文章ID'),
		'desc' => __('请输入需要特别推荐的文章ID'),
		'id' => 'stayma_arttop_id1',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('特别推荐文章2 文章ID'),
		'desc' => __('请输入需要特别推荐的文章ID'),
		'id' => 'stayma_arttop_id2',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('特别推荐文章3 文章ID'),
		'desc' => __('请输入需要特别推荐的文章ID'),
		'id' => 'stayma_arttop_id3',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => '是否开启轮播图',
		'id' => 'stayma_lbt_open',
		'std' => false,
		'desc' => __('开启后，启动顶部幻灯片'),
		'type' => 'checkbox');

$options[] = array(
		'name' => __('请选择轮播图样式'),
		'desc' => __('请输入轮播图序号。数字1：横屏轮播图，数字2：首屏三个展示轮播图'),
		'id' => 'stayma_lbt_style',
		'std' => '1',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图数量'),
		'desc' => __('请输入轮播图数量，最多8个！'),
		'id' => 'stayma_lbt_num',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【1】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_1',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【1】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_1',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【1】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_1',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【1】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_1',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【2】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_2',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【2】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_2',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【2】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_2',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【2】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_2',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【3】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_3',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【3】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_3',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【3】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_3',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【3】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_3',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【4】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_4',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【4】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_4',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【4】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_4',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【4】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_4',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【5】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_5',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【5】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_5',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【5】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_5',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【5】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_5',
		'type' => 'text');
	$options[] = array(
		'name' => __('轮播图【6】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_6',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【6】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_6',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【6】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_6',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【6】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_6',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【7】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_7',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【17】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_7',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【7】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_7',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【7】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_7',
		'type' => 'text');
	$options[] = array(
		'name' => __('轮播图【8】 图片上传'),
		'desc' => __('请上传≥952*420的图片'),
		'id' => 'stayma_lbt_img_8',
		'type' => 'upload');

	$options[] = array(
		'name' => __('轮播图【8】 跳转链接'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_link_8',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【8】 文章描述1'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text1_8',
		'type' => 'text');

	$options[] = array(
		'name' => __('轮播图【8】 文章描述2'),
		'desc' => __('请设置轮播图跳转链接'),
		'id' => 'stayma_lbt_text2_8',
		'type' => 'text');

	$options[] = array(
		'name' => __('侧边栏设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => '是否开启个人介绍小工具',
		'id' => 'is_open_about',
		'std' => true,
		'desc' => __('开启后请设置下面个人信息'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('个人头像'),
		'desc' => __('设置个人介绍显示头像'),
		'id' => 'about_img',
		'type' => 'upload');

	$options[] = array(
		'name' => __('个人名称'),
		'desc' => __('设置个人介绍显示名称'),
		'id' => 'about_name',
		'class'=>'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('所在地址'),
		'desc' => __('设置个人介绍显示地址'),
		'id' => 'about_where',
		'class'=>'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('简短描述'),
		'desc' => __('设置个人介绍显示描述'),
		'id' => 'about_text',
		'type' => 'text');

	$options[] = array(
		'name' => __('个人邮箱'),
		'desc' => __('设置个人邮箱'),
		'id' => 'about_email',
		'class'=>'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('个人QQ'),
		'desc' => __('设置个人QQ'),
		'id' => 'about_qq',
		'class'=>'mini',
		'type' => 'text');

	$options[] = array(
		'name' => '是否开启最新文章小工具',
		'id' => 'is_open_newart',
		'std' => true,
		'desc' => __('是否开启最新文章小工具'),
		'type' => 'checkbox');
	$options[] = array(
		'name' => '是否开启标签小工具',
		'id' => 'is_open_tags',
		'std' => true,
		'desc' => __('是否开启标签小工具'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('安全设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => '是否禁止评论中有链接？',
		'id' => 'no_link',
		'std' => false,
		'desc' => __('开启后，启动顶部幻灯片'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => '是否禁止纯英文评论？',
		'id' => 'open_chinese',
		'std' => false,
		'desc' => __('开启后，启动顶部幻灯片'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('页尾设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('网站声明(说明)'),
		'desc' => __('设置页尾网站声明文字'),
		'id' => 'footer_text',
		'type' => 'text');

	$options[] = array(
		'name' => __('页尾logo设置'),
		'desc' => __('如果不设置请留空(不要出现任何字符,包括空格)'),
		'id' => 'footer_logo',
		'type' => 'upload');

	$options[] = array(
		'name' => __('广告设置'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('顶部广告位1 图片上传'),
		'desc' => __('请上传1290*45的图片广告。若为空,则不开启此广告位。'),
		'id' => 'stayma_ggw_1img',
		'type' => 'upload');

	$options[] = array(
		'name' => __('顶部广告位1 链接地址'),
		'desc' => __('请设置广告1的链接地址'),
		'id' => 'stayma_ggw_1text',
		'type' => 'text');

	$options[] = array(
		'name' => __('顶部广告位2 图片上传'),
		'desc' => __('请上传1290*45的图片广告。若为空,则不开启此广告位。'),
		'id' => 'stayma_ggw_2img',
		'type' => 'upload');

	$options[] = array(
		'name' => __('顶部广告位2 链接地址'),
		'desc' => __('请设置广告1的链接地址'),
		'id' => 'stayma_ggw_2text',
		'type' => 'text');

	$options[] = array(
		'name' => __('侧边栏广告位3 HTML代码'),
		'desc' => __('请设置侧边栏广告位，支持HTML代码'),
		'id' => 'stayma_ggw_3text',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('主题DIY'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('自定义css代码'),
		'desc' => __('自定义css代码,请勿添加style标签'),
		'id' => 'stayma_css',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定义JavaScript代码'),
		'desc' => __('自定义JavaScript代码,请带上#script#标签'),
		'id' => 'stayma_javascript',
		'type' => 'textarea');


	return $options;
}