<?php
    class Usuario
    {
        private $pdo;
        public $msgErro = "";
        
        public function conectar($nome, $host, $usuario, $senha)
        {
            global $pdo;
            try
            {
                $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
            }
            catch (PDOException $e)
            {
                global $msgErro;
                $e->getMessage();
            }
        }

        public function cadastrar($nome, $nickname, $email, $senha)
        {
            global $pdo;
            // verificar se o email ou o nickname já esta cadastrado
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND nickname = :nn");
            $sql->bindValue(":e", $email);
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if($sql->rowCount()>0)
            {
                return false; //ja esta cadastrado o email e ou nickname informado
            }
            else
            {
                
                // cadastra o usuario
                $sql = $pdo->prepare("INSERT INTO usuarios (nome, nickname, email, senha, data_cadastro) VALUES (:n, :nn, :e, :s, NOW())");
                $sql->bindValue(":n", $nome);
                $sql->bindValue(":nn", $nickname);
                $sql->bindValue(":e", $email);
                $sql->bindValue(":s", md5($senha));
                $sql->execute();
                return true;
            }
        }

        public function confirmacaoCadastro($email)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND status = 0");
            $sql->bindValue(":e", $email);
            $sql->execute();
            if($sql->rowCount()>0)
            {
                $sql = $pdo->prepare("UPDATE usuarios SET status = 1 WHERE email = :e AND status = 0");
                $sql->bindValue(":e", $email);
                $sql->execute();
                return true;
            }
            else
            {
                return false;
            }
        }

        public function logar($nickname, $senha)
        {
            global $pdo;
            // verifica se o email e senha estão cadastrados e se a conta está ativa.
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = :nn AND senha = :s");
            $sql->bindValue(":nn", $nickname);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();
            if($sql->rowCount()>0)
            {
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = :nn AND senha = :s AND status = 1");
                $sql->bindValue(":nn", $nickname);
                $sql->bindValue(":s", md5($senha));
                $sql->execute();
                if($sql->rowCount()>0)
                {
                    $dados = $sql->fetch();
                    session_start();
                    $_SESSION['nickname'] = $dados[2];
                    $_SESSION['id_access'] = $dados[5];
                    return true;
                }
                elseif($sql->rowCount()==0)
                {
                    return 0;
                }
                else {
                    return false;
                }

            }
            else
            {
                return false;
            }
            
        }

        public function contactar($nome, $email, $mensagem)
        {
            global $pdo;
            $sql = $pdo->prepare("INSERT INTO contato (c_nome, c_email, c_mensagem) VALUES (:cn, :ce, :cm)");
            $sql->bindValue(":cn", $nome);
            $sql->bindValue(":ce", $email);
            $sql->bindValue(":cm", $mensagem);
            $sql->execute();
            return true;
        }

        public function editarperfil($nicknameatual, $nome, $nickname, $email, $senha, $idaccess)
        {
            global $pdo;
            // verifica se já existe o nickname informado e email
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e OR nickname = :nn");
            $sql->bindValue(":e", $email);
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if($sql->rowCount()>0)
            {
                return false;
            }
            else
            {
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = :nna");
                $sql->bindValue(":nna", $nicknameatual);
                $sql->execute();
                if($sql->rowCount()==1)
                {
                    $result = $sql->fetch();
                    
                    $sql = $pdo->prepare("UPDATE usuarios SET nome = :n, nickname = :nn, email = :e, senha = :s, id_access = :ia WHERE nickname = :nna");
                    if(empty($nome)){$nome = $result['nome'];}
                    if(empty($nickname)){$nickname = $result['nickname'];}
                    if(empty($email)){$email = $result['email'];}
                    if(empty($senha)){
                        $senha = $result['senha'];
                        $sql->bindValue(":s", $senha);
                    }else{
                        $sql->bindValue(":s", md5($senha));
                    }
                    if(empty($idaccess)){$idaccess = $result['id_access'];}
    
                    $sql->bindValue(":n", $nome);
                    $sql->bindValue(":nn", $nickname);
                    $sql->bindValue(":e", $email);
                    $sql->bindValue(":ia", $idaccess);
                    $sql->bindValue(":nna", $nicknameatual);
                    $sql->execute();
                    return true;
                }

            }
        }

        public function qtdeCreditos($nickname)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT creditos FROM usuarios WHERE nickname = :nn");
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if($sql->rowCount()>0)
            {
                $dados = $sql->fetch();
                $c = $dados[0];
                return $c;
            }
            else
            {
                return 'ERRO ^^';
            }
        }

        public function creditar($nickname, $creditos, $sinal)
        {
            global $pdo;
            if($sinal === '-'){
                $sql = $pdo->prepare("UPDATE usuarios SET creditos = creditos - :c WHERE nickname = :nn");
                $sql->bindValue(":c", $creditos);
                $sql->bindValue(":nn", $nickname);
                $sql->execute();
                if($sql->rowCount()>0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            if($sinal === '+'){
                $sql = $pdo->prepare("UPDATE usuarios SET creditos = creditos + :c WHERE nickname = :nn");
                $sql->bindValue(":c", $creditos);
                $sql->bindValue(":nn", $nickname);
                $sql->execute();
                if($sql->rowCount()>0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        public function imgPerfil($nickname)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT img FROM usuarios WHERE nickname = :nn");
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            $imgPerfil = $sql->fetch();
            return $imgPerfil[0];
        }

        public function uploadImg($nickname, $img)
        {
            global $pdo;
            $sql = $pdo->prepare("UPDATE usuarios SET img = :i WHERE nickname = :nn");
            $sql->bindValue(":i", $img);
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if ($sql->rowCount()>0){

                return true;
            }
            else {
                return false;
            }
        }

        public function getInfoUser($nickname)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = :nn");
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if($sql->rowCount()>0){
                $info = $sql->fetch();
                $tc;
                $d = new DateTime($info[8]);
                $dc = $d->format('d/m/Y');
                if ($info[5] == 0){$tc = "Free";}
                if ($info[5] == 1){$tc = "Admin";}
                $result = "<table class='table table-sm table-borderless border border-primary  text-light'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Nome:</th>
                                        <th scope='col'>".$info[1]."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Nickname:</th>
                                        <th scope='col'>".$info[2]."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Email:</th>
                                        <th scope='col'>".$info[3]."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Créditos:</th>
                                        <th scope='col'>".$info[6]."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Tipo de conta:</th>
                                        <th scope='col'>".$tc."</th>
                                    </tr>
                                    <tr>
                                        <th scope='col'>Data de Cadastro:</th>
                                        <th scope='col'>".$dc."</th>
                                    </tr>
                                </thead>
                            </table>";
                return $result;
            }
            else{
                return false;
            }
        }

        public function criarSala($master, $nomesala, $descsala, $tiposys)
        {
            global $pdo;
            $sql = $pdo->prepare("INSERT INTO salas (master, nome_sala, desc_sala, tipo_sala) VALUES (:m, :ns, :ds, :ts)");
            $sql->bindValue(":m", $master);
            $sql->bindValue(":ns", $nomesala);
            $sql->bindValue(":ds", $descsala);
            $sql->bindValue(":ts", $tiposys);
            $sql->execute();
            return true;
        }

        public function getMyRoom($master)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT * FROM salas WHERE master = :m");
            $sql->bindValue(":m", $master);
            $sql->execute();
            if($sql->rowCount()>0){
                return $sql->fetchAll();
            }
            else{
                return false;
            }
        }

        public function getAllRoom()
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT * FROM salas");
            $sql->execute();
            if($sql->rowCount()>0){
                return $sql->fetchAll();
            }
            else{
                return false;
            }
        }

        public function addRoomFav($nickname, $idsalasfav)
        {
            global $pdo;
            // verificar se a sala já esta em favoritas
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nickname = :nn AND salas_fav LIKE CONCAT('%,', :sf, ',%')");
            $sql->bindValue(":sf", $idsalasfav);
            $sql->bindValue(":nn", $nickname);
            $sql->execute();
            if($sql->rowCount()>0)
            {
                return false; //sala já esta em favoritas
            }
            else
            {
                // adiciona sala nos favoritos
                $sql = $pdo->prepare("UPDATE usuarios SET salas_fav = CONCAT(salas_fav, :sf, ',') WHERE nickname = :nn");
                $sql->bindValue(":sf", $idsalasfav);
                $sql->bindValue(":nn", $nickname);
                $sql->execute();
                return true;
            }

        }

        public function getFavRoom($master)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT salas_fav FROM usuarios WHERE nickname = :m");
            $sql->bindValue(":m", $master);
            $sql->execute();
            if($sql->rowCount()>0){
                $iddassalas = $sql->fetchAll();
                $resultfinal = explode(",", $iddassalas[0][0]);
                for ($i=0; $i <= count($resultfinal); $i++) { 
                    if ($resultfinal[$i] == "") {
                        unset($resultfinal[$i]);
                    }
                }
                $salasfav = array();
                $i = 1;
                while ($i <= count($resultfinal)) {
                    $sql = $pdo->prepare("SELECT * FROM salas WHERE id = :id");
                    $sql->bindValue(":id", $resultfinal[$i]);
                    $sql->execute();
                    array_push($salasfav, $sql->fetchAll());
                    $i++;
                }
                return $salasfav;
            }
            else{
                return false;
            }
        }

        public function getRoomInfo($id)
        {
            global $pdo;
            $sql = $pdo->prepare("SELECT * FROM salas WHERE id = :i");
            $sql->bindValue(":i", $id);
            $sql->execute();
            if ($sql->rowCount()>0){
                $result = $sql->fetch();
                return $result;
            }
            else {
                return false;
            }
        }
    }
?>