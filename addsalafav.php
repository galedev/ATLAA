<?php
    session_start();
    require_once 'CLASSES/usuarios.php';
    require_once 'options/bd.php';
    $u = new Usuario;
    // verificar se clicou no botao
    if (isset($_POST['idDaSala']))
    {
        $nickname = $_SESSION['nickname'];
        $iddasala = addslashes($_POST['idDaSala']);
        // verificar se esta td preenchido
        if(!empty($nickname) && !empty($iddasala))
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($u->addRoomFav($nickname,$iddasala))
                {
                    echo "Sala adicionada aos Favoritos!";
                }
                else
                {
                    echo "Sala já está em seus Favoritos!";
                }
            }
            else
            {
                echo "Erro: ".$u->msgErro;
            }
        }
        else
        {
            echo "Preencha todos os campos!";
        }
    }
?>