$(function(){
    $('.main').load('../panel/load/monitoring.phtml');
    $('.tab').click(function () {
        $('.tab').children('ul').removeClass('activeul').addClass('nonactiveul');
        $(this).children('ul').removeClass('nonactiveul').addClass('activeul');
        let page = $(this).data('file');
        $('.main').load('../panel/load/'+page);
    })
    $('.tab ul li').click(function () {
        $('.tab ul li').removeAttr('id');
        $(this).attr('id', 'active');
        let page =$(this).data('file');
        $('.main').load('../panel/load/'+page);
    })
})

$(function () {
    $('#profile').click(function () {
        $('.content').load('../panel/load/profile.php');
    })
})