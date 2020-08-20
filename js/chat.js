var conn;
function conectar(){

    conn = new WebSocket('wss://atlaa.herokuapp.com/wss');

    conn.onopen = function(e) {
        showMsg();
    };

    conn.onclose = function(e) {
        setTimeout(function() {
            conectar();
          }, 1000);
    };

    conn.onmessage = function(e) {
        showMsg();
        // showMsgNoDB(e.data);
    };

    conn.onerror = function(err) {

    };
};

// function showMsgNoDB (data) {
//     var how = info_room;
//     console.log('master = ', how);
//     data = JSON.parse(data);
//     var chat_content = document.getElementById('conteudo-chat-mesa');
//     if (data.nome == how){
//         var str_msg = '<span style="color: red;">'+ data.nome + ': </span>' + data.msg + '</span>';
//     }else{
//         var str_msg = '<span style="color: green;">'+ data.nome + ': </span>' + data.msg + '</span>';
//     }
//     var p = document.createElement('p');
//     p.innerHTML = str_msg;
//     chat_content.appendChild(p);
//     var sh = chat_content.scrollHeight;
//     chat_content.scrollTo(0,sh);
// };

function showMsg () {
    var chat_content = document.getElementById('conteudo-chat-mesa');
    var sh = chat_content.scrollHeight;
    chat_content.scrollTo(0,sh);
    $("#getDiv").load(' #conteudo-chat-mesa');
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