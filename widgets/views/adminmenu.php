<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<?php foreach ($items as $item): ?>
				<?php $activeClass = strpos(Yii::$app->request->url, $item['url']) !==false || ($item['url'] == 'user-text' && Yii::$app->request->url == '/texts/index') || ($item['url'] == 'language' && Yii::$app->request->url == '/translation/index') || ($item['url'] == 'user-text' && Yii::$app->request->url == '/styles/index') ? ' active': '' ?>
				<?php if (isset($item['items'])): ?>
					<li class="treeview<?php echo $activeClass?>">
						<a href="<?php echo \yii\helpers\Url::toRoute($item['url'])?>">
							<i class="fa fa-<?php echo $item['icon']?>"></i>
							<span><?php echo $item['title']?></span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php foreach ($item['items'] as $itm): ?>
								<li><a href="<?php echo \yii\helpers\Url::toRoute($itm['url'])?>" <?php foreach($itm['options'] as $key=>$opt){ echo $key . '="'.$opt.' "';} ?>><i class="fa fa-<?php echo(isset($itm['icon']) ? $itm['icon'] : 'angle-double-right') ?>"></i> <?php echo $itm['title']?></a></li>
            <?php endforeach; ?>
						</ul>
					</li>
				<?php else: ?>
					<li class="<?php echo $activeClass?>">
						<a href="<?php echo \yii\helpers\Url::toRoute($item['url'])?>">
							<i class="fa fa-<?php echo $item['icon']?>"></i> <span><?php echo $item['title']?></span>
						</a>
					</li>
				<?php endif; ?>

			<?php endforeach;?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>