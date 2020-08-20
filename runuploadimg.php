<?php
session_start();
require_once 'CLASSES/usuarios.php';
require_once 'options/bd.php';
$u = new Usuario;
$u->conectar($dbname,$host,$dbuser,$dbpass);
if($u->msgErro == "")
{
    if ($_FILES["img"]["name"] != "") 
    {
        $nickname = $_SESSION["nickname"];
        $getIMG = $_FILES["img"]["name"];
        $extIMG = end(explode(".", $getIMG));
        $nomeIMG = md5(rand(1, 1000000)).".".strtolower($extIMG);
        $dir = "imgperfil/".$nomeIMG;
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $dir))
        {
    
            if($u->uploadImg($nickname, $nomeIMG))
            {
    
                echo '<img src="../'.$dir.'" alt="perfil" class="img-thumbnail" width="200" height="200">';
            }
            else 
            {
                echo 'Erro ao subir imagem para o banco de dados!';
            }
        }
        else
        {
            
            echo 'Erro no upload';
        }
    }
    else
    {
        echo 'deu ruim!';

    }
}
else 
{
    echo "Erro: ".$u->msgErro;
}
?>