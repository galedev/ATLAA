<?php
require_once '../CLASSES/usuarios.php';
require_once '../options/bd.php';
$u = new Usuario;
if (isset($_POST['cmmsg']))
{
    $idsala = addslashes($_POST['cmidsala']);
    $nickname = addslashes($_POST['cmnickname']);
    $msg = addslashes($_POST['cmmsg']);
    $u->conectar($dbname,$host,$dbuser,$dbpass);
    if($u->msgErro == "") //sem erro
    {
        global $pdo;
        $sql = $pdo->prepare("INSERT INTO msg_mesa (id_sala, nickname, msg) VALUES (:i, :nn, :m)");
        $sql->bindValue(":i", $idsala);
        $sql->bindValue(":nn", $nickname);
        $sql->bindValue(":m", $msg);
        $sql->execute();
        if($sql->rowCount()>0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        echo "Erro: ".$u->msgErro;
    }
}
else
{
    return false;
}
?>