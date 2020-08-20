<?php
session_start();
require_once '../CLASSES/usuarios.php';
require_once '../options/bd.php';
$u = new Usuario;
if (isset($_SESSION['id_sala_atual'])) 
{
    $idsala = $_SESSION['id_sala_atual'];
    $u->conectar($dbname,$host,$dbuser,$dbpass);
    if($u->msgErro == "") //sem erro
    {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM msg_mesa WHERE id_sala = :i");
        $sql->bindValue(":i", $idsala);
        $sql->execute();
        if($sql->rowCount()>0)
        {
            return $sql->fetchAll();
            //$result = "<p><span style='color: red;'>".$info[$i][2].": </span>".$info[$i][3]."</span></p>";
        }
        else
        {
            return "nada encontrado";
        }
    }
    else
    {
        echo "Erro: ".$u->msgErro;
    }
}
else
{
    return "sessão com o id sala atual não existe";
}
?>