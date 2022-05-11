<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

<link rel="stylesheet" href="css/estilo.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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

<?php

require('banco/conexao.php');

//verificação de autenticação
$user = autentica($_SESSION['TOKEN']);
if($user){
    echo "<h1 class='text-center'>  SEJA BEM-VINDO <b style= 'color:green'>".$user['nome']."!</b></h1>";
    echo "<br><br>";

}else{
    //Redirecionar para login
    header('location: index.php');
}

?>

<div class="row">

        <div class="col-sm-4">

        <?php $foto = $user['codigo_foto']; ?>

            <figure class="figure ms-5">
                <img <?php echo 'src="imagens/'.$foto.'"'?> class="figure-img img-fluid rounded" alt="Foto de perfil">
                <figcaption class="figure-caption text-center fw-bold">Foto de perfil.</figcaption>
            </figure>
        </div>

<div class="col-sm-8">

    <div class="row">

            <div class="col">

                <label for="nome" class="form-label fw-bold">Nome completo</label>
                <input type="text" <?php echo 'value="'.$user['nome'].'"'?> disabled class="form-control border border-dark" name="nome" aria-label="Nome completo">
            </div>

            <div class="col me-5">
                <label for="email" class="form-label fw-bold">E-mail</label>
                <input  type="email" <?php echo 'value="'.$user['email'].'"'?> disabled class="form-control border-dark" name="email" aria-label="E-mail">

            </div>
    </div>

    <div class="row mt-5">
            <div class="col">
                <label for="cep" class="form-label fw-bold">cep</label>
                <input type="text" <?php echo 'value="'.$user['cep'].'"'?> disabled class="form-control border-dark" name="cep" aria-label="cep">
            </div>

            <div class="col me-5"> 
                <label for="endereco" class="form-label fw-bold">Endereço</label>
                <input type="text" <?php echo 'value="'.$user['endereco'].'"'?> disabled class="form-control border-dark" name="endereco" aria-label="endereco">
            </div>
    </div>

    <div class="row mt-5">
        <div class="col me-5">
            <label for="bairro" class="form-label fw-bold">Bairro</label>
            <input type="text" <?php echo 'value="'.$user['bairro'].'"'?> disabled class="form-control border-dark" id="bairro" name="bairro" aria-label="bairro">
        </div>
   

        <div class="col me-5">
            <label for="numero" class="form-label fw-bold">Numero</label>
            <input type="text" <?php echo 'value="'.$user['numero'].'"'?> disabled class="form-control border-dark" name="numero" aria-label="Numero">
        </div>  

        <div class="col me-5">
            <label for="complemento" class="form-label fw-bold">Complemento</label>
            <input type="text" <?php echo 'value="'.$user['complemento'].'"'?> disabled class="form-control border-dark" name="complemento" aria-label="Complemento">     
        </div>

    

            <div class="row mt-5">
                <div class="col">
                    <label for="cidade" class="form-label fw-bold">Cidade</label>
                    <input type="text" <?php echo 'value="'.$user['cidade'].'"'?> disabled class="form-control border-dark" id="cidade" name="cidade" aria-label="cidade">
                </div>

                <div class="col ms-5 ps-5">
                    <label for="estado" class="form-label fw-bold">Estado</label>
                    <input type="text" <?php echo 'value="'.$user['estado'].'"'?> disabled class="form-control border-dark w-25" id="estado" name="estado" aria-label="estado">
                </div>

                <div class="col me-5">
                    <label for="pais" class="form-label fw-bold">País</label>
                    <input type="text" <?php echo 'value="'.$user['pais'].'"'?> disabled class="form-control border-dark" name="pais" id="pais" aria-label="pais" value="">
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                <a href="logout.php" type="button" class="btn btn-danger btn-lg w-25 fs-3">Sair</a>
            </div>

</div>
    
</body>
</html>






