
const conn = io('https://atlaajs.herokuapp.com/');
const nickname = $('#cmnickname').val();

conn.on('connect', () => {
    console.log(nickname, ' conectado no chat node.js!');
    conn.emit('ninckname', nickname);
});

conn.on('disconnect', () => {
    console.log(nickname, ' desconectado no chat!');
});

conn.on('PlayersRefresh', (players) => {
    listaPlayers = Object.keys(players).map((key) => (players[key].name));
    $('#lista-players').html('');
    listaPlayers.forEach(name => {
        $('#lista-players').append(`<div class="card card-custom-grey mb-2"><div class="card-body"><p>${name}</p></div></div>`);
    });
});

conn.on('ReceiveMessage', (receivedMessage) => {
    $("#getDiv").load(' #conteudo-chat-mesa');
});

$('#form-chat-mesa').submit(function(event){
    event.preventDefault();
    var msg = $('#cmmsg');
    var user = $('#cmnickname');
    var dados = {'nome': user.val(), 'msg': msg.val()};
    dados = JSON.stringify(dados);

    if (user.val() == '') {
        alert('usuario nao informado!');
        return false;
    }
    
    if (msg.val() == '') {
        alert('Não pode mandar mensagem em branco!');
        return false;
    }
    
    $.ajax({
        type: $('#form-chat-mesa').attr('method'),
        url: $('#form-chat-mesa').attr('action'),
        data: $('#form-chat-mesa').serialize(),
        success: function(i){
            conn.emit('SendMessage', msg.val());
            $('#form-chat-mesa').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});

$('#btnJogarDados').on('click', function(event){
    event.preventDefault();

    let msg = $('#cmmsg');

    const qtdDados = $('#qtdDados').val();

    const qtdLados = $('#qtdLados').val();

    if (qtdDados == '' || qtdLados == '') {
        alert('nenhum dos compos podem ser vazios.');
        $('#qtdDados').focus();
        return false;
    }

    if (qtdDados.lenght > 3 || qtdLados.lenght > 3) {
        alert('o valor máximo é de 3 numeros');
        return false;
    }

    const resultado = () => {

        let retorno = 0;

        for (let i = 0; i < qtdDados; i++) {
            retorno += Math.floor(Math.random() * qtdLados);
        }
        return retorno;
    };

    msg.val(`Rolou ${qtdDados} dados de ${qtdLados} lados e obteve ${resultado()}`);

    $.ajax({
        type: $('#form-chat-mesa').attr('method'),
        url: $('#form-chat-mesa').attr('action'),
        data: $('#form-chat-mesa').serialize(),
        success: function(i){
            conn.emit('SendMessage', msg.val(`Rolou ${qtdDados} de ${qtdLados} e obteve ${resultado()}`));
            $('#form-chat-mesa').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });

});