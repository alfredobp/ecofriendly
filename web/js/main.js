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
            console.log('ad')
            
    })
    var prov = document.getElementById('usuarios-provincia');
    console.log("hola");
		var mun = document.getElementById('usuarios-localidad');
		new Pselect().create(prov, mun);
})