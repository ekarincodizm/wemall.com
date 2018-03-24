
<form action="<?php echo URL::toLang('search'); ?>" method="GET" class="form-search full">
    <input type="hidden" name="collection" class="search-collection" value="<?php echo Input::get('collection', 0); ?>" />
    <div class="header__box_search">
		<div class="input-group">
			<?php echo Form::text('q', strip_tags(Input::get('q')), array('class' => 'form-control alphanumeric', 'placeholder' => __('search product or brand'))); ?>
			<div class="input-group-btn">
				<button class="btn_dropdown_category search-selected" type="button" id="category" data-toggle="dropdown">
				<?php echo __('All Category'); ?> <span class="caret"></span>
				</button>
				<button class="btn_search" type="submit">
				<span class="glyphicon glyphicon-search"></span>
				</button>
				<ul class="dropdown-menu search-collections" role="menu" aria-labelledby="category">
					<li>
						<a data-collection-id="0" class="search-collections-list collection-id-0">
							<?php echo __('All Category'); ?>
						</a>
					</li>
					<?php if ( ! empty($collections)) : ?>
						<?php foreach ($collections as $item => $value) : ?>
							<li>
								<a  data-collection-id="<?php echo $value['pkey']; ?>" class="search-collections-list collection-id-<?php echo $value['pkey']; ?>" >
									<?php
									if(App::getLocale()=="th")
									{
										echo array_get($value,'name');
									}
									else
									{
										if($value['translate']!=null)
										{
											echo array_get($value,'translate.name');
										}
										else
										{
											echo array_get($value,'name');
										}
									}
									?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</form>