<?php
session_start();
if(!isset($_SESSION['nickname']))
{
    header("Location: index.php");
    exit;
}
require_once 'CLASSES/usuarios.php';
require_once 'options/bd.php';
$u = new Usuario;
$u->conectar($dbname,$host,$dbuser,$dbpass);
$result = $u->qtdeCreditos($_SESSION['nickname']);
$imgName = $u->imgPerfil($_SESSION['nickname']);
$infoUser = $u->getInfoUser($_SESSION['nickname']);
$img = "<img src='imgperfil/".$imgName."' class='card-img-top img-thumbnail img-fluid' width='200' height='200' alt='Img de Perfil'>";
?>
<html lang="pt-br">
<head><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma GALE de RPG</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php include "../inc/header_logado.html";?>
    <?php include "../inc/home_logado.html";?>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="card text-center">
                    <div class="card-header">
                        <?php echo $img; ?>
                        <button type="button" class="btn btn-primary btn-sm" style="margin-top: 16px;" data-toggle="modal" data-target="#uploadimgModal">
                            Alterar
                        </button>
                    </div>
                    <div class="card-body">
                        <h6>Conta: <span id="logado-text"><?php if($_SESSION['id_access'] == 1){echo 'Admin';}else{echo 'Free';} ?></span></h6>
                        <h6>Nickname: <?php echo $_SESSION['nickname'];?></h6>
                        <h6>Créditos: <span id="showcredit"><?php echo $result;?></span></h6>
                    </div>
					<div class="card-footer">
						<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-lobby-tab" data-toggle="pill" href="#v-pills-lobby" role="tab" aria-controls="v-pills-lobby" aria-selected="true">Lobby</a>
							<a class="nav-link" id="v-pills-opt-tab" data-toggle="pill" href="#v-pills-opt" role="tab" aria-controls="v-pills-opt" aria-selected="false">Opções</a>
                            <?php if ($_SESSION['id_access'] == 1){
                                echo '<a class="nav-link" id="v-pills-opt-adm-tab" data-toggle="pill" href="#v-pills-opt-adm" role="tab" aria-controls="v-pills-opt-adm" aria-selected="false">Opções Admin</a>';
                            } ?>
							<a class="nav-link" id="v-pills-sair-tab" data-toggle="pill" href="#v-pills-sair" role="tab" aria-controls="v-pills-sair" aria-selected="false">Sair</a>
						</div>
					</div>
				</div>
            </div>
			<div class="col-sm-9">
				<div class="card text-wrap">
					<div class="card-body">
						<div class="tab-content " id="v-pills-tabContent">
                            <!-- LOBBY -->
                            <div class="tab-pane fade show active" id="v-pills-lobby" role="tabpanel" aria-labelledby="v-pills-lobby-tab">
                                <nav class="navbar justify-content-center navbar-dark">
									<ul class="d-flex justify-content-center nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-salas-tab" data-toggle="pill" href="#pills-salas" role="tab" aria-controls="pills-salas" aria-selected="false">SALAS</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-favorito-tab" data-toggle="pill" href="#pills-favorito" role="tab" aria-controls="pills-favorito" aria-selected="false">FAVORITOS</a>
                                        </li>
									</ul>
                                </nav>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-salas" role="tabpanel" aria-labelledby="pills-salas-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h1">Salas Disponiveis!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center">Listar salas abertas!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-favorito" role="tabpanel" aria-labelledby="pills-favorito-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h1">Criar Sala</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-6">
                                                    <form action="criarsala.php" method="POST" id="form-criarsala">
                                                        <div class="form-group">
                                                            <label for="nomesala">Nome:</label>
                                                            <input class="form-control" type="text" name="nomesala" id="nomesala" placeholder="Digite o nome da sala...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="descsala">Descrição:</label>
                                                            <textarea class="form-control" name="descsala" id="descsala" placeholder="Digite a descrição da sala..."></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tiposys">Tipo de sistema:</label>
                                                            <input class="form-control" type="text" name="tiposys" id="tiposys" placeholder="Digite o tipo de sistema usado em seu jogo...">
                                                        </div>
                    
                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-primary">Criar Sala</button>
                                                        </div>
                    
                                                        <div class="alert-criarsala alert alert-danger d-none">
                                                            
                                                        </div>
                                                        <div id="success-criarsala" class="d-none"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
								</div>
                            </div>
                            <!-- OPÇÕES -->
							<div class="tab-pane fade" id="v-pills-opt" role="tabpanel" aria-labelledby="v-pills-opt-tab">
								<nav class="navbar justify-content-center navbar-dark">
									<ul class="d-flex justify-content-center nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">PERFIL</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">CONTATO</a>
                                        </li>
									</ul>
								</nav>
								<div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h1">Meu perfil!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-7">
                                                    <?php echo $infoUser; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h1">Sistema GALE de RPG!</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h1>Contato</h1>
                                                            <form action="contato.php" method="POST" id="form-contato">
                                                                <div class="form-group">
                                                                    <label for="nome">Nome:</label>
                                                                    <input class="form-control" type="text" name="nome" id="nome" placeholder="Digite seu nome...">
                                                                </div>
                            
                                                                <div class="form-group">
                                                                    <label for="email">E-mail:</label>
                                                                    <input class="form-control" type="email" name="email" id="email" placeholder="Digite seu e-mail...">
                                                                </div>
                            
                                                                <div class="form-group">
                                                                    <label for="mensagem">Mensagem:</label>
                                                                    <textarea class="form-control" name="mensagem" id="mensagem" placeholder="Digite a mensagem..."></textarea>
                                                                </div>
                            
                                                                <div class="form-group text-center">
                                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                                </div>
                            
                                                                <div class="alert-contato alert alert-danger d-none">
                                                                    Preencha o campo <span id="campo-erro"></span>!
                                                                </div>
                                                                <div id="success-contato" class="d-none"></div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
								</div>
                            </div>
                            <!-- OPÇÕES DE ADMIN -->
                            <div class="tab-pane fade" id="v-pills-opt-adm" role="tabpanel" aria-labelledby="v-pills-opt-adm-tab">
								<nav class="navbar justify-content-center navbar-dark">
									<ul class="d-flex justify-content-center nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-tickets-tab" data-toggle="pill" href="#pills-tickets" role="tab" aria-controls="pills-tickets" aria-selected="true">TICKETS</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-profile-adm-tab" data-toggle="pill" href="#pills-profile-adm" role="tab" aria-controls="pills-profile-adm" aria-selected="false">PERFIL</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-creditos-tab" data-toggle="pill" href="#pills-creditos" role="tab" aria-controls="pills-creditos" aria-selected="false">CREDITOS</a>
                                        </li>
									</ul>
								</nav>
								<div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-tickets" role="tabpanel" aria-labelledby="pills-tickets-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h3">Lista de tickets!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6>ID</h6>
                                                        </div>
                                                        
                                                        <div class="col-sm-3">
                                                            <h6>NOME</h6>
                                                        </div>
                                                        
                                                        <div class="col-sm-3">
                                                            <h6>EMAIL</h6>
                                                        </div>
                                                        
                                                        <div class="col-sm-3">
                                                            <h6>MENSAGEM</h6>
                                                        </div>
                                                    </div><hr>
                                                    <div id="result-tickets"></div><hr>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" id="update-ticket" class="btn btn-info">Atualizar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h3">Editar perfil!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-6">
                                                    <form id="form-editar-perfil" method="POST" action="editaperfil.php">
                                                        <div class="form-group">
                                                            <label for="nicknameatual">Nickname a ser alterado:</label>
                                                            <input class="form-control" type="text" name="nicknameatual" id="anicknameatual" placeholder="Nickname atual...">
                                                        </div><hr>

                                                        <div class="form-group">
                                                            <label for="nome">Nome:</label>
                                                            <input class="form-control" type="text" name="nome" id="anome" placeholder="Novo nome...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nickname">Nickname:</label>
                                                            <input class="form-control" type="text" name="nickname" id="anickname" placeholder="Novo nickname...">
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="email">E-mail:</label>
                                                            <input class="form-control" type="email" name="email" id="aemail" placeholder="Novo e-mail...">
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="senha">Senha:</label>
                                                            <input class="form-control" type="password" name="senha" id="asenha" placeholder="Nova senha..."></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="idaccess">Acesso:</label>
                                                            <input class="form-control" type="text" name="idaccess" id="aidaccess" placeholder="1 para admin e 0 para usuario...">
                                                        </div>
                            
                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                                        </div>
                            
                                                        <div class="alert alert-danger d-none">
                                                            Preencha o campo <span id="a-campo-erro"></span>!
                                                        </div>
                                                        <div id="success-edit-perfil" class="d-none"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile-adm" role="tabpanel" aria-labelledby="pills-profile-adm-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h3">Editar perfil!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-6">
                                                    <form id="form-editar-perfil" method="POST" action="editaperfil.php">
                                                        <div class="form-group">
                                                            <label for="nicknameatual">Nickname a ser alterado:</label>
                                                            <input class="form-control" type="text" name="nicknameatual" id="anicknameatual" placeholder="Nickname atual...">
                                                        </div><hr>

                                                        <div class="form-group">
                                                            <label for="nome">Nome:</label>
                                                            <input class="form-control" type="text" name="nome" id="anome" placeholder="Novo nome...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nickname">Nickname:</label>
                                                            <input class="form-control" type="text" name="nickname" id="anickname" placeholder="Novo nickname...">
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="email">E-mail:</label>
                                                            <input class="form-control" type="email" name="email" id="aemail" placeholder="Novo e-mail...">
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="senha">Senha:</label>
                                                            <input class="form-control" type="password" name="senha" id="asenha" placeholder="Nova senha..."></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="idaccess">Acesso:</label>
                                                            <input class="form-control" type="text" name="idaccess" id="aidaccess" placeholder="1 para admin e 0 para usuario...">
                                                        </div>
                            
                                                        <div class="form-group text-center">
                                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                                        </div>
                            
                                                        <div class="alert alert-danger d-none">
                                                            Preencha o campo <span id="a-campo-erro"></span>!
                                                        </div>
                                                        <div id="success-edit-perfil" class="d-none"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-creditos" role="tabpanel" aria-labelledby="pills-creditos-tab">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="d-flex justify-content-center">
                                                        <p class="text-center h3">Editar créditos!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row justify-content-md-center">
                                                <div class="col-sm-6">
                                                    <form id="form-editar-creditos" method="POST" action="editacreditos.php">
                                                        <div class="form-group">
                                                            <label for="nicknamec">Nickname a ser creditado:</label>
                                                            <input class="form-control" type="text" name="nicknamec" id="nicknamec" placeholder="Nickname...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="creditos">Créditos:</label>
                                                            <input class="form-control" type="number" name="creditos" id="creditos">
                                                        </div>

                                                        <div class="form-group text-center">
                                                            <button type="submit" name="adicionar" id="adicionarcredito" class="btn btn-primary" value="adicionar">Adicionar</button>
                                                            <button type="submit" name="remover" id="removercredito" class="btn btn-primary" value="remover">Remover</button>
                                                        </div>
                            
                                                        <div class="alert-creditos alert alert-danger d-none">
                                                            Preencha o campo <span id="credito-erro"></span>!
                                                        </div>
                                                        <div id="success-edit-credito" class="d-none"></div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
								</div>
                            </div>
                            <!-- SAIR -->
							<div class="tab-pane fade" id="v-pills-sair" role="tabpanel" aria-labelledby="v-pills-sair-tab">
								<a class="btn btn-danger" href="./sair.php" role="button">Confirmar logout</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!-- Incluides Modal -->
    <?php
    include '../inc/uploadimg.html';
    ?>
	<!-- Scripts -->
    <script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/form.js"></script>
</body>
</html>