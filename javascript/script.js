$('#form_comentario').submit(function(e){
    e.preventDefault();

    var comentario = $('#ds_comentario').val();

    //console.log(comentario);

    $.ajax({
        url: '',
        method: 'POST',
        data: {comentario: comentario},
        dataType: 'json'
    }).done(function(result){
        console.log(result);
    });
});