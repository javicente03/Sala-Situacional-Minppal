// Detonar evento submit de formulario id = form

$('#form').submit(function(event) {
    event.preventDefault();
    
    // obtener datos del formulario
    let data = $(this).serializeArray();

    // enviar datos al servidor
    $.ajax({
        url: '/auth/login',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.log(error);
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
            }, false);
            return xhr;
        }
    });
});