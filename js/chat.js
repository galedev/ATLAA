
const conn = io('http://192.168.0.102:4000');
const nickname = $('#cmnickname').val();

conn.on('connect', () => {
    console.log(nickname, ' conectado no chat node.js!');
    conn.emit('ninckname', nickname);
});

conn.on('disconnect', () => {
    console.log(nickname, ' desconectado no chat!');
});

conn.on('PlayersRefresh', (players) => {
   
});

conn.on('ReceiveMessage', (receivedMessage) => {
    
});

conn.on('ReceiveMessage', (msg) => {
    console.log(msg.data);
});

function showMsg () {
    // var chat_content = document.getElementById('conteudo-chat-mesa');
    // var sh = chat_content.scrollHeight;
    // chat_content.scrollTo(0,sh);
    $("#getDiv").load(' #conteudo-chat-mesa');
};

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
            console.log(i);
            conn.emit('SendMessage', msg);
            $('#form-chat-mesa').trigger('reset');
        },
        erro: function(){
            alert('Erro inesperado');
        }
    });
});