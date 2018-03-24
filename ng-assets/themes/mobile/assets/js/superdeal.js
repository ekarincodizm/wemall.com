
$(document).ready(function(e){
    //swipe slider
    var mySwiper = new Swiper(".swiper-container",{
        paginationClickable: true,
        slidesPerView: "auto"
    });

    var testSwipe = {
        scrollbar: '.swiper-scrollbar',
        scrollbarHide: true,
        slidesPerView: 'auto',
        grabCursor: true,
        freeMode: true
    };



    var $active = $('.extra-wow-category-container li.active');
    var allLi = $('.extra-wow-category-container li');
    var lastestLi = (allLi.length) - 1;

    if(lastestLi > 0)
    {
        var lastest_2 = lastestLi-1;
    }

    var index_active = $('.extra-wow-category').find('li').index($active);

    if( (index_active > 1) && (lastestLi != index_active) && (lastest_2 != index_active) )
    {
        var testSwipe = {
            scrollbar: '.swiper-scrollbar',
            scrollbarHide: true,
            slidesPerView: 'auto',
            grabCursor: true,
            freeMode: true,
            centeredSlides:true
        };
    }

    // category swiper
    var categorySwipe = new Swiper( '.extra-wow-category-container', testSwipe );

    if( (index_active > 1)  && (lastestLi != index_active) && (lastest_2 != index_active) )
    {
        categorySwipe.swipeTo(index_active);
    }
    else
    {
        categorySwipe.swipeTo((index_active-1));
    }

});