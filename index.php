<?php
session_start();
if (isset($_SESSION['id_sala_atual']))
{
    unset($_SESSION['id_sala_atual']);
}
?>
<html lang="pt-br">
<head><meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema GALE de RPG</title>
    <link rel="shortcut icon" href="icon/logo_gif.gif">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php include "inc/header.html";?>
    <?php include "inc/home.html";?>
    <?php include "inc/footer.html";?>
    

    <!-- Incluides Modal -->
    <?php
    include 'inc/register.html';
    include 'inc/erroLogin.html';
    include 'inc/reenviaremailconf.html';
    ?>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/form.js"></script>
</body>
</html>