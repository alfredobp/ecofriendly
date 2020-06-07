$(function () {
	$('.irArriba').click(function(){
		$('body, html').animate({
			scrollTop: '0px'
		}, 300);
	});
 
	$(window).scroll(function(){
		if( $(this).scrollTop() > 0 ){
			$('.irArriba').slideDown(300);
		} else {
			$('.irArriba').slideUp(300);
		}
	});
    $('.modalButton2').click(function () {
        $('#modal2').modal('show')
            .find('#modalContent2')
            .load($(this).attr('value'));
    });
    $('.modalButton3').click(function () {

        $('#modal3').modal('show')
            .find('#modalContent3')
            .load($(this).attr('value'));


    })
    $('.modalButton4').click(function () {
        $('#modal4').modal('show')
            .find('#modalContent4')
            .load($(this).attr('value'));


    })
    $('.modalButton7').click(function () {
        $('#modal5').modal('show')
            .find('#modalContent7')
            .load($(this).attr('value'));


    })

    $('.modalButton5').click(function () {
        $('#modal5').modal('show')
            .find('#modalContent5')
            .load($(this).attr('value'));


    })
    $('.modalButton6').click(function () {
        $('#modal6').modal('show')
            .find('#modalContent6')
            .load($(this).attr('value'));


    })
})