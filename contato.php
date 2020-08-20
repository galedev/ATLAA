<?php
    require_once 'CLASSES/usuarios.php';
    require_once 'options/bd.php';
    $u = new Usuario;

    // verificar se clicou no botao FORMULARIO DE CONTATO
    if (isset($_POST['nome']))
    {
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $mensagem = addslashes($_POST['mensagem']);
        // verificar se esta td preenchido
        if(!empty($nome) && !empty($email) && !empty($mensagem))
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($u->contactar($nome,$email,$mensagem))
                {
                    echo "<div class='alert alert-success'>Mensagem enviada, você terá uma resposta em até 24 horas. Obrigado!";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Mensagem não enviada!</div>";
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