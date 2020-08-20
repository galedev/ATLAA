// login
$('#form-login').submit(function(e){
    var lnickname = $('#lnickname');             // variavel que pega o ID do campo nickname
    var lsenha = $('#lsenha');                   // variavel que pega o ID do campo senha
    //var lerro = $('.alert-login');               // variavel que pega a classe alert das mensagem de alerta
    var lcampo = $('#campo-erro-login');         // variavel que pega o id do span da mensagem de erro de preenchimento dos campos

    //lerro.addClass('d-none');                    // adiciona a classe para ocultar a mensagem de erro que aparece quando o form é submetido
    $('.is-invalid').removeClass('is-invalid');

    // validação do campo email do form (se email for vazio)
    if (lnickname.val()== '') {
        //lerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        lcampo.html('nickname');                   // nome do campo que nao foi preenchido.
        lnickname.focus();                          // foca o cursor no campo nickname
        lnickname.addClass('is-invalid');           // sinaliza o campo nickname como invalido
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo senha do form (se senha for vazio)
    if (lsenha.val()== '') {
        //lerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        lcampo.html('senha');                    // nome do campo que nao foi preenchido.
        lsenha.focus();                          // foca o cursor no campo senha
        lsenha.addClass('is-invalid');           // sinaliza o campo senha como invalido
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // Envia o form quando chegar aqui (caso passe de todas validações acima.)
    //return false;
    e.preventDefault();
    $.ajax({
        type: $('#form-login').attr('method'),
        url: $('#form-login').attr('action'),
        data: $('#form-login').serialize(),
        success: function(i){
            if(i == "<div class='alert alert-success'>Logado com sucesso!</div>"){
                $('#success-login').html(i);
                // $('#modalSuccessLogin').modal();
                $(location).attr('href','apprpg')
            }
            else if(i == "<div class='alert alert-danger'>Conta desativada. Confirme seu cadastro clicando no link enviado para seu e-mail!</div>"){
                $('#modalReenviarEmailConf').modal();                
            }
            else{
                $('#success-login').html(i);
                $('#modalSuccessLogin').modal();
            }
            $('#form-login').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

// reenviar email confirmar cadastro
$('#reenviaremaildeconfirmacao').submit(function(e){
    var remail = $('#remail');

    $('.is-invalid').removeClass('is-invalid');
    $('#success-sender').addClass('d-none');

    if (remail.val()== '') {
        remail.focus();
        remail.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }
    e.preventDefault();
    $.ajax({
        type: $('#reenviaremaildeconfirmacao').attr('method'),
        url: $('#reenviaremaildeconfirmacao').attr('action'),
        data: $('#reenviaremaildeconfirmacao').serialize(),
        success: function(i){
            $('#success-sender').html(i);
            $('#success-sender').removeClass('d-none');
            $('#reenviaremaildeconfirmacao').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

// cadastro
$('#form-cadastro').submit(function(e){
    var cnome = $('#cnome');                      // variavel que pega o ID do campo nome
    var cnickname = $('#cnickname');                      // variavel que pega o ID do campo nickname
    var cemail = $('#cemail');                    // variavel que pega o ID do campo email
    var csenha = $('#csenha');                    // variavel que pega o ID do campo senha
    var cconfSenha = $('#cconfSenha');            // variavel que pega o ID do campo confirmar senha
    var cerro = $('.alert-cadastro');            // variavel que pega a classe alert das mensagem de alerta
    var ccampo = $('#campo-erro-cadastro');      // variavel que pega o id do span da mensagem de erro de preenchimento dos campos

    $('#success-cadastro').addClass('d-none');
    cerro.addClass('d-none');                    // adiciona a classe para ocultar a mensagem de erro que aparece quando o form é submetido
    $('.is-invalid').removeClass('is-invalid');

    // validação do campo nome do form (se nome for vazio)
    if (cnome.val()== '') {
        cerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        ccampo.html('nome');                     // nome do campo que nao foi preenchido.
        cnome.focus();
        cnome.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo nickname do form (se nome for vazio)
    if (cnickname.val()== '') {
        cerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        ccampo.html('nickname');                     // nome do campo que nao foi preenchido.
        cnickname.focus();
        cnickname.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo email do form (se nome for vazio)
    if (cemail.val()== '') {
        cerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        ccampo.html('e-mail');                   // nome do campo que nao foi preenchido.
        cemail.focus();
        cemail.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo mensagem do form (se nome for vazio)
    if (csenha.val()== '') {
        cerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        ccampo.html('senha');                    // nome do campo que nao foi preenchido.
        csenha.focus();
        csenha.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo mensagem do form (se nome for vazio)
    if (cconfSenha.val()== '') {
        cerro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        ccampo.html('confirmar senha');                    // nome do campo que nao foi preenchido.
        cconfSenha.focus();
        cconfSenha.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // Envia o form quando chegar aqui (caso passe de todas validações acima.)
    //return false;
    e.preventDefault();
    $.ajax({
        type: $('#form-cadastro').attr('method'),
        url: $('#form-cadastro').attr('action'),
        data: $('#form-cadastro').serialize(),
        success: function(i){
            $('#success-cadastro').html(i);
            $('#success-cadastro').removeClass('d-none');
            $('#form-cadastro').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

// contato
$('#form-contato').submit(function(e){
    let nome = $('#nome');                      // variavel que pega o ID do campo nome
    let email = $('#email');                    // variavel que pega o ID do campo email
    let mensagem = $('#mensagem');              // variavel que pega o ID do campo mensagem
    let erro = $('.alert-contato');                     // variavel que pega a calsse alert das mensagem de alerta
    let campo = $('#campo-erro');               // variavel que pega o id do span da mensagem de erro de preenchimento dos campos

    $('#success-contato').addClass('d-none');
    erro.addClass('d-none');                    // adiciona a classe para ocultar a mensagem de erro que aparece quando o form é submetido
    $('.is-invalid').removeClass('is-invalid');

    // validação do campo nome do form (se nome for vazio)
    if (nome.val()== '') {
        erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        campo.html('nome');                     // nome do campo que nao foi preenchido.
        nome.focus();
        nome.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo email do form (se nome for vazio)
    if (email.val()== '') {
        erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        campo.html('e-mail');                     // nome do campo que nao foi preenchido.
        email.focus();
        email.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // validação do campo mensagem do form (se nome for vazio)
    if (mensagem.val()== '') {
        erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
        campo.html('mensagem');                     // nome do campo que nao foi preenchido.
        mensagem.focus();
        mensagem.addClass('is-invalid');
        return false;                           // campo vazio retorna falso pra nao submeter o form
    }

    // Envia o form quando chegar aqui (caso passe de todas validações acima.)
    //return true;
    e.preventDefault();
    $.ajax({
        type: $('#form-contato').attr('method'),
        url: $('#form-contato').attr('action'),
        data: $('#form-contato').serialize(),
        success: function(i){
            $('#success-contato').html(i);
            $('#success-contato').removeClass('d-none');
            $('#form-contato').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

// consulta os tickets do banco de dados - admin only
$('#update-ticket').on("click", function(){
    $.ajax({
        url: "../loadtickets.php",
        success: function(result){
            $('#result-tickets').html(result);
        },
        erro: function(){
            $('#result-tickets').html('Erro inesperado!');
        }
    })
});

// Edita o perfill - admin only
$('#form-editar-perfil').submit(function(e){
    var anicknameatual = $('#anicknameatual');
    var aerro = $('.alert-cadastro');
    var acampo = $('#a-campo-erro');

    $('#success-edit-perfil').addClass('d-none');
    aerro.addClass('d-none');
    $('.is-invalid').removeClass('is-invalid');
    
    if (anicknameatual.val()== '') {
        aerro.removeClass('d-none');
        acampo.html('nickname atual');
        anicknameatual.focus();
        anicknameatual.addClass('is-invalid');
        return false; 
    }
    
    e.preventDefault();
    $.ajax({
        type: $('#form-editar-perfil').attr('method'),
        url: $('#form-editar-perfil').attr('action'),
        data: $('#form-editar-perfil').serialize(),
        success: function(i){
            $('#success-edit-perfil').html(i);
            $('#success-edit-perfil').removeClass('d-none');
            $('#form-editar-perfil').trigger('reset');
        },
        erro: function(i){
            alert('Erro inesperado');
        }
    });
});

// adiciona creditos - admin only
$('#adicionarcredito').click(function(){
    $('#form-editar-creditos').submit(function(e){
        let nickname = $('#nicknamec');
        let creditos = $('#creditos');
        let erro = $('.alert-creditos');
        let campo = $('#credito-erro');

        $('#success-edit-credito').addClass('d-none');
        erro.addClass('d-none');                    // adiciona a classe para ocultar a mensagem de erro que aparece quando o form é submetido
        $('.is-invalid').removeClass('is-invalid');

        if (nickname.val()== '') {
            erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
            campo.html('nickname');                    // nome do campo que nao foi preenchido.
            nickname.focus();
            nickname.addClass('is-invalid');
            return false;                           // campo vazio retorna falso pra nao submeter o form
        }
        if (creditos.val()== '') {
            erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
            campo.html('creditos');                    // nome do campo que nao foi preenchido.
            creditos.focus();
            creditos.addClass('is-invalid');
            return false;                           // campo vazio retorna falso pra nao submeter o form
        }
        e.preventDefault();
        $.ajax({
            type: $('#form-editar-creditos').attr('method'),
            url: $('#form-editar-creditos').attr('action'),
            data: $('#form-editar-creditos').serialize()+'&adicionar=adicionar',
            success: function(i){
                $('#success-edit-credito').html(i);
                $('#success-edit-credito').removeClass('d-none');
                $('#form-editar-creditos').trigger('reset');
                //window.document.location.reload();
            },
            erro: function(){
                alert('Erro inesperado');
            }
        });
    });
});

// remove creditos - admin only
$('#removercredito').click(function(){
    $('#form-editar-creditos').submit(function(e){
        let nickname = $('#nicknamec');
        let creditos = $('#creditos');
        let erro = $('.alert-creditos');
        let campo = $('#credito-erro');

        $('#success-edit-credito').addClass('d-none');
        erro.addClass('d-none');                    // adiciona a classe para ocultar a mensagem de erro que aparece quando o form é submetido
        $('.is-invalid').removeClass('is-invalid');

        if (nickname.val()== '') {
            erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
            campo.html('nickname');                    // nome do campo que nao foi preenchido.
            nickname.focus();
            nickname.addClass('is-invalid');
            return false;                           // campo vazio retorna falso pra nao submeter o form
        }
        if (creditos.val()== '') {
            erro.removeClass('d-none');             // remove a classe d-none da div que contem a mensagem de erro
            campo.html('creditos');                    // nome do campo que nao foi preenchido.
            creditos.focus();
            creditos.addClass('is-invalid');
            return false;                           // campo vazio retorna falso pra nao submeter o form
        }
        e.preventDefault();
        $.ajax({
            type: $('#form-editar-creditos').attr('method'),
            url: $('#form-editar-creditos').attr('action'),
            data: $('#form-editar-creditos').serialize()+'&remover=remover',
            success: function(i){
                $('#success-edit-credito').html(i);
                $('#success-edit-credito').removeClass('d-none');
                $('#form-editar-creditos').trigger('reset');
                //window.document.location.reload();
            },
            erro: function(){
                alert('Erro inesperado');
            }
        });
    });
});

// upload de imagem de perfil - all users
$('#form-upload-img').submit(function(r){
    let img = $('#img');
    let erro = $('.alert-img');
    let btn_enviar = $('#enviar');
    btn_enviar.prop('disabled');

    $('#uploadimg').removeClass('d-none');
    $('#textload').removeClass('d-none')
    $('#success-upload-img').addClass('d-none');
    erro.addClass('d-none');
    $('.is-invalid').removeClass('is-invalid');

    if(img.val() == '') {
        erro.removeClass('d-none');
        img.addClass('is-invalid');
        $('#uploadimg').addClass('d-none');
        $('#textload').addClass('d-none');
        return false
    }
    let property = document.getElementById("img").files[0];
    let nameIMG = property.name;
    let extIMG = nameIMG.split(".").pop().toLowerCase();
    let sizeIMG = property.size;
    if (jQuery.inArray(extIMG, ['gif', 'jpeg', 'jpg', 'png', 'jfif']) == -1) {
        $('#uploadimg').addClass('d-none');
        $('#textload').addClass('d-none');
        erro.html('Arquivo de imagem invalido!');
        erro.removeClass('d-none');
        return false
    }
    if (sizeIMG > 9000000) {
        $('#uploadimg').addClass('d-none');
        $('#textload').addClass('d-none');
        erro.html('Tamanho do arquivo não pode ser maior do que 9mb!');
        erro.removeClass('d-none');
        return false
    }
    else {
        let form_data = new FormData();
        form_data.append("img", property);
        r.preventDefault();
        $.ajax({
            xhr: function(){
                let xhr = new window.XMLHttpRequest();
        
                // Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        $('#textload').html(Math.round(percentComplete*100)+'%');
                        $('#progressbar').width(percentComplete*100+'%');
                    }
               }, false);
        
               return xhr;
            },
            method: $('#form-upload-img').attr('method'),
            url: $('#form-upload-img').attr('action'),
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(){
                //$('#success-upload-img').html('Enviando...');
            },
            success: function(i){
                $('#atual-img').addClass('d-none');
                $('#success-upload-img').removeClass('d-none');
                $('#success-upload-img').html(i);
                $('#success-upload-img').removeClass('d-none');
                $('#form-upload-img').trigger('reset');
                $('#progressbar').width('0%');
                $('#uploadimg').addClass('d-none');
                //$('#textload').addClass('d-none')
                $('#textload').html('<div class="alert alert-success text-center" role="alert">Imagem carregada com sucesso!</div>');
                $('#xclose').click(function(){
                    window.document.location.reload();
                })
                $('#bclose').click(function(){
                    window.document.location.reload();
                })
            },
            erro: function(err){
                $('#success-upload-img').html(err);
            }
        });
    }
});

// criar sala - all users
$('#form-criarsala').submit(function(e){
    var nome_sala = $('#nomesala');
    var desc_sala = $('#descsala');
    var tipo_sala = $('#tiposys');
    
    $('.is-invalid').removeClass('is-invalid');

    if (nome_sala.val()== '') {
        nome_sala.focus();
        nome_sala.addClass('is-invalid');
        return false;
    }
    if (desc_sala.val()== '') {
        desc_sala.focus();
        desc_sala.addClass('is-invalid');
        return false;
    }
    if (tipo_sala.val()== '') {
        tipo_sala.focus();
        tipo_sala.addClass('is-invalid');
        return false;
    }
    e.preventDefault();
    $.ajax({
        type: $('#form-criarsala').attr('method'),
        url: $('#form-criarsala').attr('action'),
        data: $('#form-criarsala').serialize(),
        success: function(i){
            if (i != "Erro ao criar sala!") {
                $('#criarsalamodal').modal('hide');
                $("#listMyRoom").load(' #listMyRoom');
                $("#listRoom").load(' #listRoom');
            } else {
                alert(i);
            }
            $('#form-criarsala').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

//adicionar sala ao favoritos
$('.btnaddsalafav').click(function(e){
    var idform = $(this).parent().attr('id');

    e.preventDefault();
    $.ajax({
        type: $('#'+idform).attr('method'),
        url: $('#'+idform).attr('action'),
        data: $('#'+idform).serialize(),
        success: function(i){
            $("#favRoom").load(' #favRoom');
            alert(i);
        },
        erro: function(){
            alert('Erro, entrar em contato com o suporte!');
        }
    })
});