 <?php if(stayma('stayma_xxinfo_open')): ?>
    <div class="intr-header hidden-xs" style="<?php echo !stayma('stayma_lbt_open') ? 'background-image:  url('.stayma('stayma_xxinfo_img').');' : '' ;?>">
        <?php if(stayma('stayma_lbt_open')): ?>
        <!-- 第一二中轮播图 -->
            <?php if(stayma('stayma_lbt_style') == '1'): ?>

            <div class="swiper-container" id="swiper-1">
                <div class="swiper-wrapper">
                <?php if(stayma('stayma_lbt_num') > 0): ?>
                <?php for($i = 1; $i <= stayma('stayma_lbt_num'); $i++): ?>
                    <div class="swiper-slide" style="background-image: url(<?php echo stayma('stayma_lbt_img_'.$i)?>);">
                        <a href="<?php echo stayma('stayma_lbt_link_'.$i)?>">
                        <div class="swiper-info-text" style="text-align:center">
                            <h3><?php echo stayma('stayma_lbt_text1_'.$i) ?></h3>
                        </div>
                        </a>
                    </div>
                <?php endfor; ?>
                <?php endif; ?>
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
                <!-- 如果需要导航按钮 -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <<?php endif; ?>
        <?php else: ?>
            <div class="container">
                <div class="row intr-header-info">
                    <div>
                        <h3><?php echo stayma('stayma_xxinfo_text1') ?></h3>
                        <p><?php echo stayma('stayma_xxinfo_text2') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>