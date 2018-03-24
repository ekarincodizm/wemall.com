<div id='search-box' class="itm">
    <form action='<?php echo URL::toLang("search2");?>' id='search-form' method='get' target='_top'>
        <input id='search-text' name='q' placeholder='<?php echo __("search product or brand");?>' type='text' autocomplete="off"/>
        <button id='search-button' type='submit'><span class="glyphicon glyphicon-search"></span></button>
    </form>
    <div class="search-suggestion" id="suggest-result" style="display: none">
        <ul class="search-suggestion__list"></ul>
    </div>
</div>