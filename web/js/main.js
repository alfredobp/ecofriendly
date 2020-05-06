$(function () {

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
    
    $('.modalButton5').click(function () {
        $('#modal5').modal('show')
            .find('#modalContent5')
            .load($(this).attr('value'));
      

    })
})