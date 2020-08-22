
const conn = io('http://192.168.0.102:4000');

conn.on('connect', () => {
    console.log('Conectado no chat node.js!');
});

conn.on('disconnect', () => {
    console.log('Desconectado no chat!');
});

conn.on('PlayersRefresh', (players) => {
    console.log(players);
});

conn.on('ReceiveMessage', (receivedMessage) => {
    console.log(receivedMessage);
});

function showMsg () {
    // var chat_content = document.getElementById('conteudo-chat-mesa');
    // var sh = chat_content.scrollHeight;
    // chat_content.scrollTo(0,sh);
    $("#getDiv").load(' #conteudo-chat-mesa');
};

$('#form-chat-mesa').submit(function(event){
    event.preventDefault();
    var user = $('#cmnickname');
    var msg = $('#cmmsg');
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
    
    if (conn.readyState == 1){
        $.ajax({
            type: $('#form-chat-mesa').attr('method'),
            url: $('#form-chat-mesa').attr('action'),
            data: $('#form-chat-mesa').serialize(),
            success: function(i){
                console.log(i);
                conn.send(dados);
                $('#form-chat-mesa').trigger('reset');
            },
            erro: function(){
                alert('Erro inesperado');
            }
        });
    }else{
        console.log('Deu Pau no seu chat ai!')
    }
});