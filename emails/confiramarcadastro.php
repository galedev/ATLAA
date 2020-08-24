<?php
    require_once '../CLASSES/usuarios.php';
    require_once '../options/bd.php';
    $u = new Usuario;
    // verificar se clicou no botao
    if (isset($_GET['email']))
    {
        $email = addslashes($_GET['email']);
        // verificar se esta td preenchido
        if(!empty($email) && $_GET['status'] == 1)
        {
            $u->conectar($dbname,$host,$dbuser,$dbpass);
            if($u->msgErro == "") //sem erro
            {
                if ($u->confirmacaoCadastro($email))
                {
                    ?>
                    <script>
                        alert('Cadastro confirmado com sucesso. Faça seu login e divirta-se!');
                        window.location.href = "https://atlaa.gale.net.br/";
                    </script>
                    <?php
                }
                else
                {
                    ?>
                    <script>
                        alert('Essa conta já foi confirmada. Pode efetuar o login normalmente!');
                        window.location.href = "https://atlaa.gale.net.br/";
                    </script>
                    <?php
                }
            }
            else
            {
                echo "Erro: ".$u->msgErro;
            }
        }
        else
        {
            ?>
            <script>
                alert('Erro na confirmação do cadastro!');
                window.location.href = "https://rpg.gale.net.br/";
            </script>
            <?php
        }
    }
?>