$(document).ready(function(){
	UpdateNews();
	$('#bxslider-hilight-banner').bxSlider({
        pager: false,
        nextSelector: '#slider-next',
        prevSelector: '#slider-prev',
        nextText: '<img src="themes/itruemart/assets/images/news/news-hilight-next.jpg" />',
        prevText: '<img src="themes/itruemart/assets/images/news/news-hilight-prev.jpg" />'
    });
});

var timeOut;
var idx = -1;

function UpdateNews() {
    this.updateLength = $('#ht-content li').length;
    $('#ht-content li:eq(' + (idx + 1 > this.updateLength - 1 ? 0 : idx + 1) + ')').fadeIn(3000);
    $('#ht-content li:eq(' + (idx < 0 ? this.updateLength : idx) + ')').fadeOut(3000);
    idx = idx + 1 > this.updateLength - 1 ? -1 : idx + 1;
    timeOut = setTimeout('UpdateNews()', 5000);
}