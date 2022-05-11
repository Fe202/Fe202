<?php
require('banco/conexao.php');

if (isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){

    //Receber os dados vindos do post e limpar
    $email = limpaPost($_POST['email']);
    $senha = limpaPost($_POST['senha']);
    $senha_cript = sha1($senha);

    //Verificar se o usuário existe
    $sql = $pdo->prepare("SELECT * FROM tabela_perfil WHERE email=? AND senha=? LIMIT 1");
    $sql->execute(array($email,$senha_cript));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if ($usuario){
        //Existe usuário
        
            //Criar token
        $token = sha1(uniqid().date('d-m-Y-H-i-s'));

        //Atualizar o token deste usuario no banco
        $sql = $pdo->prepare("UPDATE tabela_perfil SET token=? WHERE email=? AND senha=?");

        if ($sql->execute(array($token,$email,$senha_cript))){
            //Armazenar esse token na sessão
            $_SESSION['TOKEN'] = $token;
            header('location: restrita.php');
        }
        
    }else{
        $erro_login = "Usuário ou senha incorreto!"; 
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
 
    <link rel="stylesheet" href="css/estilo.css">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="js/jquery-3.6.0.js"></script>
</head>
<body>

    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Menu1</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Menu2<e></a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Menu3</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Menu4</a></li>
                </ul>

                <div class="text-end">
                    <a href="index.php" type="button" class="btn btn-outline-light me-2">Logar</a>
                    <a href="cadastrar.php" type="button" class="btn btn-warning">Cadastrar</a>
                </div>
            </div>
        </div>
    </header>
    <br>

    <h1 class="text-center">Login</h1>
    <br>

    <form method="post">

    <?php if (isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
            <div class="text-center sucesso animate__animated animate__rubberBand">Cadastrado com sucesso!</div>

        <?php } ?>

        <?php if (isset($erro_login)){ ?>
        <div class="text-center erro-geral animate__animated animate__rubberBand"> 
        <?php echo $erro_login; ?> 
        </div>
        <?php } ?>

        
        
            <div class="row justify-content-center">
                <div class="form-floating mb-3 w-25">
                    <input name="email" type="email" class="form-control" placeholder="email">
                    <label for="email">E-mail</label>
                  </div>
            </div>
              <div class="row justify-content-center">
                  <div class="form-floating w-25">
                    <input name="senha" type="password" class="form-control" placeholder="senha">
                    <label for="senha">Senha</label>
                  </div>
              </div>
              <br>
              <div class="container text-center">
                  <div class="row justify-content-center">
                      <div class="col-12">
                          <button type="submit" class="btn btn-primary w-25 fs-3 btn-sm">Logar</button>
                        </div>
                        <br><br><br>
                      <div class="col-12">
                          <a href="cadastrar.php" type="button" class="btn btn-primary btn-sm w-25 fs-3">Cadastrar</a>
                        </div>
                  </div>
              </div>
    </form>
    
    <?php if (isset($_GET['result']) && ($_GET['result']=="ok")){ ?>
    <script>
    setTimeout(() => {
        $('.sucesso').hide();
                    
    }, 3000);
    </script>  
    <?php } ?> 
    
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
