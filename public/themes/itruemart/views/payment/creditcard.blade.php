<div class="content-home sub">

	<div class="breadcrumbs">
		<div id="link_map">
			<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
				<a class="map" itemprop="url" href="<?php echo URL::tolang('/');?>"
				title="Shopping Online"> <span itemprop="title">Shopping Online</span>
			</a>
			</span> &gt; <a class="map">ชำระเงินผ่านบัตรเครดิต</a>
		</div>
	</div>

	<div id="wrapper_content">
		{{-- start content --}}
        <form accept-charset="utf-8" class="" id="frm_submit" method="post" name="">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-5 control-label" for="card_holder_name"><?php echo __('Card Holder Name');?> :</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="card_holder_name" name="card_holder_name" placeholder="<?php echo __('Card Holder Name');?>" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label" for="card_number"><?php echo __('Card Number');?> :</label>
                    <div class="col-sm-7">
                        <input class="form-control" id="card_number" name="card_number" placeholder="<?php echo __('Card Number');?>" type="text" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label" for="expired"><?php echo __('Card Expired');?> :</label>
                    <div class="form-inline col-sm-5">
                        <select name="expired" id="expired_month" autocomplete="off" class="form-control" placeholder="<?php echo __('Expired Month');?>">
                            @foreach( Helpers::array_month_cc() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                     /
                        <select name="expired" id="expired_year" autocomplete="off" class="form-control" placeholder="<?php echo __('Expired Year');?>">
                            @foreach( Helpers::genMoreTenYears() as $value)
                                <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        </div>
                </div>
                <div class="col-sm-5 box-submit">
                    <input class="btn btn-paid" type="button" value="<?php echo __('payment');?>">
                </div>
            </div>
        </form>
	</div>
</div>