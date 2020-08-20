var conn = new WebSocket('wss://atlaa.herokuapp.com:8085');

conn.onopen = function(e) {
    console.log('Conectado no chat!');
    console.log(e);
    console.log(e.data);
};

conn.onclose = function(e) {
    console.log('Desconectado do chat!')
};

conn.onmessage = function(e) {
    showMsg(e.data);
};

function showMsg (data) {
    data = JSON.parse(data);
    var chat_content = document.getElementById('conteudo-chat-mesa');
    var str_msg = '<p><span style="color: red;">'+ data.nome + ': </span>' + data.msg + '</span></p>';
    // chat_content.innerHTML += str_msg;
    chat_content.appendChild(str_msg);
}

$('#form-chat-mesa').submit(function(event){
    event.preventDefault();
    var user = $('#cmnickname');
    var msg = $('#cmmsg');
    var dados = {'nome': user.val(), 'msg': msg.val()};

    if (user.val() == '') {
        alert('usuario nao informado!');
        return false;
    }
    if (msg.val() == '') {
        alert('Não pode mandar mensagem em branco!');
        return false;
    }

    dados = JSON.stringify(dados);
    conn.send(dados);
    $('#form-chat-mesa').trigger('reset');
});
