var conn;
function conectar(){

    conn = new WebSocket('wss://atlaa.herokuapp.com/wss');

    conn.onopen = function(e) {
        console.log('Conectado no chat: ', e.target);
    };

    conn.onclose = function(e) {
        console.log('Desconectado do chat, reconectando em 1 segundo... ', e.reason);
        setTimeout(function() {
            conectar();
          }, 1000);
        
    };

    conn.onmessage = function(e) {
        showMsg(e.data);
        console.log('msg enviada');
        
    };

    conn.onerror = function(err) {
        console.log('erro encontrado no socket, conexão fechada.',err.message);
    };
};

function showMsg (data) {
    data = JSON.parse(data);
    var chat_content = document.getElementById('conteudo-chat-mesa');
    var str_msg = '<span style="color: red;">'+ data.nome + ': </span>' + data.msg + '</span>';
    var p = document.createElement('p');
    p.innerHTML = str_msg;
    chat_content.appendChild(p);
};

conectar();

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
    
    if (conn.readyState == 2 || conn.readyState == 3){
        console.log('Desconectado do chat');
        conectar();
    }else if (conn.readyState == 0){
        console.log('Conectando ao chat');
    }else if (conn.readyState == 1){
        console.log('Conectado ao chat')
        conn.send(dados);
        $('#form-chat-mesa').trigger('reset');
        showMsg(dados);
    }else{
        console.log('Deu Pau no seu chat carai')
    }
});