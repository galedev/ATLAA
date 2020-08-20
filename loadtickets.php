<?php
require_once 'CLASSES/usuarios.php';
require_once 'options/bd.php';
$u = new Usuario;
$u->conectar($dbname,$host,$dbuser,$dbpass);
if ($u->msgErro == "") //sem erro
{
    global $pdo;
    $sql = $pdo->query("SELECT * FROM contato");
    if ($sql->rowCount() > 0)
    {
        foreach ($sql->fetchAll() as $result)
        {
            echo "<div class='row'>
                    <div class='col-sm-3'>
                        <h6>".$result[0]."</h6>
                    </div>

                    <div class='col-sm-3'>
                        <h6>".$result[1]."</h6>
                    </div>

                    <div class='col-sm-3'>
                        <h6>".$result[2]."</h6>
                    </div>

                    <div class='col-sm-3'>
                    <p class='text-break'>".$result[3]."</p>
                    </div>
                </div><hr>";
        }
    }
    else
    {
        echo "<div class='alert alert-danger'>Lista de Tickets Vazia!</div>";
    }
}
else
{
    echo "Erro: ".$u->msgErro;
}
?>