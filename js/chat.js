var conn = new WebSocket('wss://atlaa.herokuapp.com/wss');

conn.onopen = function(e) {
    console.log('Conectado no chat!');
};

conn.onclose = function(e) {
    conn = new WebSocket('wss://atlaa.herokuapp.com/wss');
};

conn.onmessage = function(e) {
    // var msg = document.getElementById('conteudo-chat-mesa');
    // msg.innerHTML = msg.innerHTML + e.data + '\n';
    // msg.innerHTML = msg.innerHTML + '<p><span style="color: red;">'+ e.data.nome + ': </span>' + e.data.msg + '</span></p>';
    showMsg(e.data);
};

$('#form-chat-mesa').submit(function(event){
    event.preventDefault();
    var user = $('#cmnickname');
    var msg = $('#cmmsg');

    if (user.val() == '') {
        alert('usuario nao informado!');
        return false;
    }
    if (msg.val() == '') {
        alert('Não pode mandar mensagem em branco!');
        return false;
    }

    var dados = {'nome': user.val(), 'msg': msg.val()};
    dados = JSON.stringify(dados);
    conn.send(dados);
    $('#form-chat-mesa').trigger('reset');
});

function showMsg (data) {
    data = JSON.parse(data);
    var chat_content = document.getElementById('conteudo-chat-mesa');
    var str_msg = '<p><span style="color: red;">'+ data.nome + ': </span>' + data.msg + '</span></p>';
    chat_content.innerHTML = chat_content.innerHTML + str_msg;
}