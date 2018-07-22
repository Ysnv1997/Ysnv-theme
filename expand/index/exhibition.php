    <div class="intr-header hidden-xs" style="<?php echo !stayma('stayma_lbt_open') ? 'background-image:  url('.stayma('stayma_xxinfo_img').');' : '' ;?>">
        <?php if(stayma('stayma_lbt_open')): ?>
            <div class="swiper-container" id="swiper-<?php echo stayma('stayma_lbt_style');?>">
                <div class="swiper-wrapper">
                <?php if(stayma('stayma_lbt_num') > 0): ?>
                <?php for($i = 1; $i <= stayma('stayma_lbt_num'); $i++): ?>

                    <div class="swiper-slide" style="background-image: url(<?php echo stayma('stayma_lbt_img_'.$i)?>);">
                        <a href="<?php echo stayma('stayma_lbt_link_'.$i)?>">
                        <div>
                            <h3><?php echo stayma('stayma_lbt_text1_'.$i) ?></h3>
                            <p><?php echo stayma('stayma_lbt_text2_'.$i) ?></p>
                        </div>
                        </a>
                    </div>
                <?php endfor; ?>
                <?php endif; ?>
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
                <!-- 如果需要导航按钮 -->
                <div class="swiper-button-prev">
                    <i class="glyphicon glyphicon-menu-left"></i>
                </div>
                <div class="swiper-button-next">
                    <i class="glyphicon glyphicon-menu-right"></i>
                </div>
            </div>
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