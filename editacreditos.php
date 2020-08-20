<?php
require_once 'CLASSES/usuarios.php';
require_once 'options/bd.php';
$u = new Usuario;

if(isset($_POST['adicionar']))
{
    $nickname = addslashes($_POST['nicknamec']);
    $creditos = addslashes($_POST['creditos']);
    if(!empty($nickname) && !empty($creditos))
    {
        $u->conectar($dbname,$host,$dbuser,$dbpass);
        if($u->msgErro == "")
        {
            if($u->creditar($nickname, $creditos, '+'))
            {
                echo "<div class='alert alert-success'>Adicionado ".$creditos." créditos para ".$nickname."</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Nick name não encontrado!</div>";
            }
        }
        else
        {
            echo "Erro: ".$u->msgErro;
        }
    }
    else
    {
        echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
    }
}
elseif(isset($_POST['remover']))
{
    $nickname = addslashes($_POST['nicknamec']);
    $creditos = addslashes($_POST['creditos']);
    if(!empty($nickname) && !empty($creditos))
    {
        $dbname = "epiz_26051822_rpgdemesa";
        $host = "sql313.epizy.com";
        $dbuser = "epiz_26051822";
        $dbpass = "YK2ttgR1VM";
        $u->conectar($dbname,$host,$dbuser,$dbpass);
        if($u->msgErro == "")
        {
            if($u->creditar($nickname, $creditos, '-'))
            {
                echo "<div class='alert alert-success'>Removido ".$creditos." créditos do ".$nickname."</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Nick name não encontrado!</div>";
            }
        }
        else
        {
            echo "Erro: ".$u->msgErro;
        }
    }
    else
    {
        echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
    }
}
else
{
    echo "<div class='alert alert-danger'>Não recebeu valores!</div>";
}