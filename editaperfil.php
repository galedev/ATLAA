<?php
require_once 'CLASSES/usuarios.php';
require_once 'options/bd.php';
$u = new Usuario;
if (isset($_POST['nome']))
{
    $nicknameatual = addslashes($_POST['nicknameatual']);
    $nome = addslashes($_POST['nome']);
    $nickname = addslashes($_POST['nickname']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $idaccess = addslashes($_POST['idaccess']);
    $u->conectar($dbname,$host,$dbuser,$dbpass);
    if($u->msgErro == "") //sem erro
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE nickname = :nna");
        $sql->bindValue(":nna", $nicknameatual);
        $sql->execute();
        if($sql->rowCount()>0)
        {
            if ($u->editarperfil($nicknameatual,$nome,$nickname,$email,$senha,$idaccess))
            {
                echo "<div class='alert alert-success'>Dados atualizados com sucesso!</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Email e/ou nickname já cadastrados!</div>";
            }
        }
        else
        {
            echo "<div class='alert alert-danger'>Nenhum nickname encontrado!</div>";
        }
    }
    else
    {
        echo "Erro: ".$u->msgErro;
    }
}
else
{
    echo "<div class='alert alert-danger'>Não recebeu valores!</div>";
}
?>