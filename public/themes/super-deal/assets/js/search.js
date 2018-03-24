$(function() {
    
    var $search_selected = $('.search-selected');
    var $search_collection = $('.search-collection');
    
    $('.search-collections-list').on('click', function() {
        
        var id = $(this).data('collection-id');
        var name = $(this).text();
        
        $search_selected.html(name + '<span class="caret"></span>');
        $search_collection.val(id);
        
    });
    
    $search_selected.html($('.collection-id-'+$('.search-collection').val()).text()+'<span class="caret"></span>');


    $("#key_brand").keyup(function(event) {
    	var input = $("#key_brand").val();
    	var filter = input.toUpperCase();
    	var lis = $("ul.list li");

        lis.each(function(){
            var $this = $(this);
            var name = $this.find('a').html();
            if (name.toUpperCase().indexOf(filter) == 0) {
                $this.css('display', 'list-item');
            } else {
                $this.css('display', 'none');
            }
        });

    });

});
