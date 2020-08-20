<?php
    require_once 'CLASSES/usuarios.php';
    require_once 'options/bd.php';
    $u = new Usuario;
    // verificar se clicou no botao
    if (isset($_POST['lnickname']))
    {
        $nickname = addslashes($_POST['lnickname']);
        $senha = addslashes($_POST['lsenha']);
        // verificar se esta td preenchido
        if(!empty($nickname) && !empty($senha))
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($u->logar($nickname,$senha))
                {
                    echo "<div class='alert alert-success'>Logado com sucesso!</div>";
                }
                elseif ($u->logar($nickname,$senha) === 0)
                {
                    echo "<div class='alert alert-danger'>Conta desativada. Confirme seu cadastro clicando no link enviado para seu e-mail!</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Nickname e/ou senha estão incorretos!</div>";
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
?>