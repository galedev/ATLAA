<?php
session_start();
if(!isset($_SESSION['nickname']))
{
    header("Location: ../index.php");
    exit;
}
require_once '../CLASSES/usuarios.php';
require_once '../options/bd.php';
$u = new Usuario;
$u->conectar($dbname,$host,$dbuser,$dbpass);
$result = $u->qtdeCreditos($_SESSION['nickname']);
$imgName = $u->imgPerfil($_SESSION['nickname']);
$infoUser = $u->getInfoUser($_SESSION['nickname']);
$img = "<img src='../imgperfil/".$imgName."' style='border-radius: 50%; border: 3px solid white;' class='img-fluid' alt='Img de Perfil'>";
$cmnickname = $_SESSION['nickname'];
$id_room = $_GET['id'];
$room_info = $u->getRoomInfo($id_room);
$_SESSION['id_sala_atual'] = $id_room;
?>
<html lang="pt-br">
<head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma ATLAA de RPG</title>
    <link rel="shortcut icon" href="../icon/logo_gif.gif">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <?php include "inc/header_play.html";?>
    <?php include "inc/home_play.html";?>
    <?php include "../inc/footer.html";?>
    <!-- Incluides Modal -->
    <?php
    include "../inc/uploadimg.html";?>
	<!-- Scripts -->
    <script src="../js/jquery-3.5.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
    <script src="../js/form.js"></script>
    <script>var info_room = "<?php echo $room_info[1]; ?>"</script>
    <script src="../js/chat.js"></script>
</body>
</html>