// Detonar evento submit de formulario id = form

$('#form').submit(function(event) {
    event.preventDefault();

    // obtener el boton submit del formulario
    let btn = $(this).find('button[type="submit"]');
    // dar display none al boton submit
    btn.css('display', 'none');
    // obtener el .loader del formulario
    let loader = $(this).find('.loader');
    // agregar la clase .show al loader
    loader.addClass('show');
    
    // obtener datos del formulario
    let data = $(this).serializeArray();
    // obtener method y url desde las data del formulario
    let method = $(this).data('method');
    let url = $(this).data('url');
    // obtener tipo de accion luego de success, puede ser static o redirect
    let action = $(this).data('action');
    // obtener la url de redireccionamiento desde las data del formulario (opcional)
    let redirect = $(this).data('redirect');

    console.log(method, url)

    // enviar datos al servidor
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function(response) {
            let res = JSON.parse(response);
            showToast('success', res.message);

            if (action == 'redirect') {
                setTimeout(function() {
                    // redireccionar a la url especificada
                    window.location.href = redirect;
                }, 2000);
            } else {
                // eliminar el loader
                loader.removeClass('show');
                // mostrar el boton submit
                btn.css('display', 'block');
            }
        },
        error: function(error) {
            // estoy recibiendo desde el servidor un json con el error
            let err = JSON.parse(error.responseText);
            console.log(err.error);
            showToast('error', err.error);
            // eliminar el loader
            loader.removeClass('show');
            // mostrar el boton submit
            btn.css('display', 'block');
        },
        complete: function() {
            console.log('Petición realizada');
        },
        // saber cuanta data se esta enviando
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    let percent = Math.round((e.loaded / e.total) * 100);
                    console.log(percent);
                }
            });
            return xhr;
        }
    });
});