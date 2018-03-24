
<form action="<?php echo URL::to('search'); ?>" method="GET" class="form-search full">
    
    <?php echo Form::text('q', Input::get('q'), array('placeholder' => __('search product or brand'), ' autocomplete' => 'off')); ?>
    
    <div class="btn-group">
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="search-selected"><?php echo __('All Category');?></span> <span class="caret"></span></button>
            <ul class="dropdown-menu search-collections">
                <li>
                    <a data-collection-id="0" class="search-collections-list collection-id-0" style="cursor: pointer;"><?php echo __('All Category'); ?></a>
                </li>
                <?php foreach ($collections as $value): ?>
                <li>
                    <a data-collection-id="<?php echo $value['pkey']; ?>" class="search-collections-list collection-id-<?php echo $value['pkey']; ?>" style="cursor: pointer;">
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
            </ul>
        </div>
        <input type="hidden" name="collection" class="search-collection" value="<?php echo Input::get('collection', 0); ?>" />
        <button class="btn btn-danger search-query"><i class="glyphicon glyphicon-search"></i></button>
    </div>
</form>