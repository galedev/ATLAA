<?php
    session_start();
    require_once 'CLASSES/usuarios.php';
    require_once 'options/bd.php';
    $u = new Usuario;
    // verificar se clicou no botao
    if (isset($_POST['nomesala']))
    {
        $master = $_SESSION['nickname'];
        $nomesala = addslashes($_POST['nomesala']);
        $descsala = addslashes($_POST['descsala']);
        $tiposys = addslashes($_POST['tiposys']);
        // verificar se esta td preenchido
        if(!empty($master) && !empty($nomesala) && !empty($descsala) && !empty($tiposys))
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($u->criarSala($master,$nomesala,$descsala,$tiposys))
                {
                    $u->getMyRoom($master);
                }
                else
                {
                    echo "Erro ao criar sala!";
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