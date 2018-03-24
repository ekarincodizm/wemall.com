<div class="title">
    <h1><?php echo __('step2-choose-shipping-address'); ?></h1>
</div>
<div class="in-form">
    <div id="address_list_container" data-href="<?php echo Url::route('ajax.post.customer.saveaddr'); ?>">
        <?php if ( ! empty($shipping_address['data'])) : ?>
       <?php foreach ($shipping_address['data'] as $key => $value) : ?>        
        <div data-id="<?php echo $value['customer_addresses_id']; ?>" class="<?php echo ($key == 0) ? 'address-box-active' : 'address-box'; ?>">
            <div class="address-inbox">
                <p style="padding-top:5px;">
                </p><h2><?php echo $value['customer_name']; ?></h2>
                <p></p>
                <p style="padding:10px 0px 10px 0px;">
                    <?php echo $value['address']; ?>
                    <?php echo $value['district_name']; ?> <?php echo $value['city_name']; ?>
                    <?php echo $value['province_name']; ?> <?php echo $value['postcode']; ?> <br>
                    <?php echo trans('step2.phone'); ?>: <?php echo $value['phone']; ?>
                </p>
                <p>
                    <input class="<?php echo ($key == 0) ? 'form-bot-address-active' : 'form-bot-address'; ?>" name="" type="button" value="<?php echo __("step2-nextstep-btn"); ?>">
                </p>
                <div class="ad-dress">
                    <div class="address-delete left"><a data-toggle="modal" data-target="modalConfirm" href="#" class="delete-ship-addr" data-href="<?php echo url('ajax/customers/delete-ship-addr?id='.$value['customer_addresses_id']); ?>"><?php echo __('step2-delete-addr'); ?></a></div>
                    <div class="address-edit left"> <a href="#" class="edit-ship-addr" data-href="<?php echo URL::toLang('ajax/customers/edit-ship-addr?id='.$value['customer_addresses_id']); ?>"><?php echo __('step2-edit-addr'); ?></a></div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="add-addres">
            <div style="padding-top:160px; text-align:center;">
                <h2><a id="add-address-btn" href="javascript:;"><?php echo __('step2-new-ship-addr'); ?></a></h2>
            </div>
            <div style="display:none">
                <div id="inline_content" style="padding:10px; background:#fff;">
                    <p><strong>This content comes from a hidden element on this page.</strong></p>
                    <p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
                    <p><a id="click" href="#" style="padding:5px; background:#ccc;">Click me, it will be preserved!</a></p>

                    <p><strong>If you try to open a new Colorbox while it is already open, it will update itself with the new content.</strong></p>
                    <p>Updating Content Example:<br>
                        <a class="ajax" href="../content/ajax.html">Click here to load new content</a></p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <input type="hidden" id="url-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo __('step2-confirm-delete'); ?></h4>
            </div>
            <div class="modal-body">
                <?php echo __('step2-are-you-sure-delete-ship-addr'); ?>
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnCancel" class="btn btn-default" data-dismiss="modal"><?php echo __('step2-close'); ?></button>
                <button type="button" id="btnConfirmDelete" class="btn btn-danger"><?php echo __('step2-want-to-delete'); ?></button>                
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <input type="hidden" id="url-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"><?php echo __('step2-message'); ?></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">                
                <button type="button" id="btnOK" class="btn btn-primary" data-dismiss="modal"><?php echo __('step2-ok'); ?></button>
              
            </div>
        </div>
    </div>
</div>

<?php /**
<div class="modal fade" id="modalConfirm">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo trans('step2.are_you_sure_delete_ship_addr'); ?></h4>
      </div>
      
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('step2.close'); ?></button>
        <button type="button" class="btn btn-primary"><?php echo trans('step2.confirm'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
*/ ?>
