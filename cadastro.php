<?php
    require_once 'CLASSES/usuarios.php';
    require_once 'options/bd.php';
    
    $u = new Usuario;
    
    // verificar se clicou no botao
    if (isset($_POST['cnome']))
    {
        $nome = addslashes($_POST['cnome']);
        $nickname = addslashes($_POST['cnickname']);
        $email = addslashes($_POST['cemail']);
        $senha = addslashes($_POST['csenha']);
        $confSenha = addslashes($_POST['cconfSenha']);

        // verificar se esta td preenchido
        if(!empty($nome) && !empty($nickname) && !empty($email) && !empty($senha) && !empty($confSenha))
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($senha == $confSenha)
                {
                    if ($u->cadastrar($nome,$nickname,$email,$senha))
                    {
                        include 'emails/cadastro.php';
                    }
                    else
                    {
                        echo "<div class='alert alert-danger'>Email ja cadastrado</div>";
                    }
                }
                else
                {
                    echo "<div class='alert alert-danger'>senha e confirmar senha nao conferem !</div>";
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