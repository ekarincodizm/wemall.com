$(function () {

    var $search_selected = $('.search-selected');
    var $search_collection = $('.search-collection');

    $('.search-collections-list').on('click', function () {

        var id = $(this).data('collection-id');
        var name = $(this).text();

        $search_selected.html(name + '<span class="caret"></span>');

        var collection_name = name.trim();
        if (collection_name == 'ทุกหมวดหมู่สินค้า' || collection_name == 'All Category') {
            collection_name = '';
        }

        $search_collection.val(collection_name);


    });

    var collection_name = $('.search-collection').val();

    if (collection_name != '') {
        $search_selected.html(collection_name + '<span class="caret"></span>');
    }

    $("#key_brand").keyup(function (event) {
        var input = $("#key_brand").val();
        var filter = input.toUpperCase();
        var lis = $("ul.list li");

        lis.each(function () {
            var $this = $(this);
            var name = $this.find('a').html();
            if (name.toUpperCase().indexOf(filter) == 0) {
                $this.css('display', 'list-item');
            } else {
                $this.css('display', 'none');
            }
        });

    });

    $('form.form-search').submit(function (event) {
        event.preventDefault();

        var collection_name = $('.search-collection').val();
        var txt = encodeURIComponent($('input[name="q"]').val());
        var submitUrl = $(this).attr("action") + "?";
        var query = "";

        if (collection_name == '') {
            query = "q=" + txt;
        } else {
            query = "q=" + txt + "&collection=" + collection_name;
        }

        window.location.href = submitUrl + query;

        return false;
    });

});
