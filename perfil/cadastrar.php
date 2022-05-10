<?php

require('banco/conexao.php');

if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['repete_senha']) && isset($_POST['cep']) && isset($_POST['endereco']) && isset($_POST['bairro']) && isset($_POST['numero']) && isset($_POST['cidade']) && isset($_POST['estado']) && isset($_POST['pais'])) {
    

    if(empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['repete_senha']) or empty($_POST['cep']) or empty($_POST['endereco']) or empty($_POST['bairro']) or empty($_POST['numero']) or empty($_POST['cidade']) or empty($_POST['estado']) or empty($_POST['pais'])){
    $erro_geral = "Todos os campos são obrigatórios!";

    }else{
        $nome = limpaPost($_POST['nome']);
        $email = limpaPost($_POST['email']);
        $senha = limpaPost($_POST['senha']);
        $senha_cript = sha1($senha);
        $repete_senha = limpaPost($_POST['repete_senha']);
        $cep = limpaPost($_POST['cep']);
        $endereco = limpaPost($_POST['endereco']);
        $bairro = limpaPost($_POST['bairro']);
        $numero = limpaPost($_POST['numero']);
        $complemento = limpaPost($_POST['complemento']);
        $cidade = limpaPost($_POST['cidade']);
        $estado = limpaPost($_POST['estado']);
        $pais = limpaPost($_POST['pais']);


        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $erro_nome = "Somente permitido letras e espaços em branco!
            ";
          }

          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Formato de email inválido!";
          }

          if (!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])\S{8,30}$/',$senha)) {
            $erro_senha = "A senha deve ter pelo menos um número, uma letra maiúscula, uma letra minúscula e no mínimo 8 caracteres";
          }

          if ($senha !== $repete_senha){
              $erro_repete_senha = "Senhas diferentes!";
          }

          if (preg_match("/[a-zA-Z\s]/",$cep) || strlen($cep) != 9 || !preg_match("/[-]/",$cep)) {
              $erro_cep = "8 números sem espaços em branco!";
          }

          if (preg_match("/[0-9]/",$endereco)) {
              $erro_endereco = "Apenas letras e espaços em branco!";
          }

          if (!preg_match("/^[a-zA-Z-' ]*$/",$bairro)) {
            $erro_bairro = "Somente permitido letras e espaços em branco!
            ";
          }

          if (preg_match('/[a-zA-Z\s]/',$numero) || preg_match('/[-+.*!@#$%&*()`´^~<>,.;:?\'"]/',$numero)) {
              $erro_numero = "Apenas números!";
          }

          if (preg_match("/[0-9]/",$cidade)) {
            $erro_cidade = "Apenas letras e espaços em branco!";
          }

          if (preg_match("/[0-9]/",$estado) || strlen($estado) != 2 || !preg_match("/[A-Z]/",$estado)) {
            $erro_estado = "Duas letras maiúsculas!";
          }

          if (preg_match("/[0-9]/",$pais)) {
            $erro_pais = "Apenas letras e espaços em branco!";
          }

            if (isset($_FILES['foto'])){

                $codigo_foto="";
                $tamanhoMax = 2097152; //2MB
                $permitido = ["jpg","jpeg","png","mp4"];
                $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                //Verifica o tamanho do arquivo
                if ($_FILES['foto']['size'] >= $tamanhoMax){
                    $erro_foto = 'Tamanho máximo de 2 MB. Não foi possivel fazer upload!';
                    }else{
                    //Verifica a extensão
                        if (in_array($extensao, $permitido)){
                            $pasta = "imagens/";
                            if (!is_dir($pasta)){
                                mkdir($pasta, 0755);
                            }
                                $tmp = $_FILES['foto']['tmp_name'];
                                $novoNome = uniqid().".$extensao";
                                $codigo_foto = $novoNome;

                            if (move_uploaded_file($tmp,$pasta.$novoNome)){
                                        
                                }else{
                                    $erro_foto = "Não foi possível fazer upload!";
                                }

                            }else{
                                $erro_foto = "Extensão '(".$extensao.")' não permitida!";
                        }
                    }
            }


          if (!isset($erro_geral) && !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha) && !isset($erro_repete_senha) && !isset($erro_cep) && !isset($erro_endereco) && !isset($erro_bairro) && !isset($erro_numero) && !isset($erro_cidade) && !isset($erro_estado) && !isset($erro_pais) && !isset($erro_foto)){

            //Verifica se o usuário já existe

              $sql = $pdo->prepare("SELECT * FROM tabela_perfil WHERE email=? LIMIT 1");
              $sql->execute(array($email));
              $usuario = $sql->fetch();

            if (!$usuario){
                $token="";
                date_default_timezone_set('America/Sao_Paulo');
                $data=date('d/m/Y');
                $sql = $pdo->prepare("INSERT INTO tabela_perfil VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                if ($sql->execute(array($nome,$email,$senha_cript,$cep,$endereco,$bairro,$numero,$complemento,$cidade,$estado,$pais,$token,$data,$codigo_foto))){
                     
                        header('location: index.php?result=ok');
                      } 

              }else{
                  $erro_geral = "Usuário já cadastrado!";
              }
          }

    }

}


?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="css/estilo.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.1.4.pack.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
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
    <h1 class="text-center">Cadastrar</h1>
    <br>


    <form method="post" enctype="multipart/form-data">

    <?php if (isset($erro_geral)){ ?>
    <div class="erro-geral animate__animated animate__rubberBand">
        <?php echo $erro_geral; ?>
    </div>
    <?php } ?>
    <br>

    <div class="row">

        <div class="col-4">

            <figure class="figure ms-5">
                <img src="imagens/avatar.png" class="figure-img img-fluid rounded" alt="Foto de perfil">
                <figcaption class="figure-caption text-center fw-bold">Sua foto vai aparecer aqui</figcaption>
            </figure>
        </div>

<div class="col-8">

    <div class="row">

<div class="col">
    <label for="nome" class="form-label fw-bold">Nome completo</label>
    <input <?php if(isset($erro_geral) or isset($erro_nome)){echo 'class="form-control border border-danger"' ;} ?> type="text" class="form-control border border-dark" name="nome" placeholder="Ex: João da Silva" aria-label="Nome completo" <?php if (isset($_POST['nome'])){echo "value='".$_POST['nome']."'";} ?>>

    <?php if (isset($erro_nome)) { ?>
    <div class="erro"><?php echo $erro_nome; ?> </div>
    <?php } ?>
</div>

<div class="col me-5">
    <label for="email" class="form-label fw-bold">E-mail</label>
    <input <?php if(isset($erro_geral) or isset($erro_email)){echo 'class="form-control border-danger"' ;} ?> type="email" class="form-control border-dark" name="email" placeholder="exemplo@email.com" aria-label="E-mail"
    <?php if (isset($_POST['email'])){echo "value='".$_POST['email']."'";} ?>>

    <?php if (isset($erro_email)){ ?>
    <div class="erro">
        <?php echo $erro_email; ?>
    </div>
    <?php } ?>
</div>
</div>

<div class="row mt-5">
    <div class="col">
        <label for="senha" class="form-label fw-bold">Senha</label>
        <input <?php if(isset($erro_geral) or isset($erro_senha)){echo 'class="form-control border-danger"' ;} ?> type="password" class="form-control border-dark" name="senha" placeholder="Ex: senha123" aria-label="Senha" <?php if (isset($_POST['senha'])){echo "value='".$_POST['senha']."'";} ?>>

        <?php if (isset($erro_senha)){ ?>
        <div class="erro">
            <?php echo $erro_senha; ?>
        </div>
        <?php } ?>
    </div>

    <div class="col me-5">
        <label for="repete_senha" class="form-label fw-bold">Repete senha</label>
        <input <?php if(isset($erro_geral) or isset($erro_repete_senha)){echo 'class="form-control border-danger"' ;} ?> type="password" class="form-control border-dark" name="repete_senha" placeholder="Ex: senha123" aria-label="Repete senha"
        <?php if (isset($_POST['repete_senha'])){echo "value='".$_POST['repete_senha']."'";} ?>>

        <?php if (isset($erro_repete_senha)){ ?>
        <div class="erro">
            <?php echo $erro_repete_senha; ?>
        </div>
        <?php } ?>
    </div>
</div>

<div class="row mt-5">
    <div class="col mt-5 me-5">
        <label for="cep" class="form-label fw-bold">Cep</label>
        <input <?php if(isset($erro_geral) or isset($erro_cep)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" name="cep" id="cep" placeholder="Ex: 12345-678" aria-label="cep" <?php if (isset($_POST['cep'])){echo "value='".$_POST['cep']."'";} ?>>

        <?php if (isset($erro_cep)){ ?>
        <div class="erro">
            <?php echo $erro_cep; ?>
        </div>
        <?php } ?>
    </div>

    <div class="col mt-5 me-5">
        <label for="endereco" class="form-label fw-bold">Endereço</label>
        <input <?php if(isset($erro_geral) or isset($erro_endereco)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" id="endereco" name="endereco" placeholder="Rua brasil" aria-label="Endereço" <?php if (isset($_POST['endereco'])){echo "value='".$_POST['endereco']."'";} ?>>

        <?php if (isset($erro_endereco)){ ?>
        <div class="erro">
            <?php echo $erro_endereco; ?>
        </div>
        <?php } ?>
    </div>
</div>

<div class="row mt-5">
    <div class="col me-5">
        <label for="bairro" class="form-label fw-bold">Bairro</label>
        <input <?php if(isset($erro_geral) or isset($erro_bairro)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" id="bairro" name="bairro" placeholder="Ex: Cambuci" aria-label="bairro"
    
             <?php if (isset($_POST['bairro'])){echo "value='".$_POST['bairro']."'";} ?>> <?php if (isset($erro_bairro)){ ?>
        <div class="erro">
            <?php echo $erro_bairro; ?>
        </div>
            <?php } ?>
    </div>

    <div class="col me-5">
        <label for="numero" class="form-label fw-bold">Numero</label>
        <input <?php if(isset($erro_geral) or isset($erro_numero)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" name="numero" placeholder="1234" aria-label="Numero"
    
            <?php if (isset($_POST['numero'])){echo "value='".$_POST['numero']."'";} ?>> <?php if (isset($erro_numero)){ ?>
        <div class="erro">
            <?php echo $erro_numero; ?>
        </div>
            <?php } ?>
    </div>

    <div class="col me-5">
        <label for="complemento" class="form-label fw-bold">Complemento</label>
        <input type="text" class="form-control border-dark" name="complemento" placeholder="Ex: Apartamento 84 Bloco A" aria-label="Complemento" 
        <?php if (isset($_POST['complemento'])){echo "value='" .$_POST['complemento']."'";} ?> >     
    </div>
</div>

</div>

    </div>
<div class="row mt-5">

    <div class="col ms-5">
    <label for="cidade" class="form-label fw-bold">Cidade</label>
<input <?php if(isset($erro_geral) or isset($erro_cidade)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" id="cidade" name="cidade" placeholder="Ex: São Paulo" aria-label="cidade"
<?php if (isset($_POST['cidade'])){echo "value='".$_POST['cidade']."'";} ?>>

<?php if (isset($erro_cidade)){ ?>
<div class="erro">
    <?php echo $erro_cidade; ?>
</div>
<?php } ?>
</div>

<div class="col ms-5 ps-5">
    <label for="estado" class="form-label fw-bold">Estado</label>
    <input <?php if(isset($erro_geral) or isset($erro_estado)){echo 'class="form-control border-danger w-25"' ;} ?> type="text" class="form-control border-dark w-25" id="estado" name="estado" placeholder="Ex: SP" aria-label="estado"
    <?php if (isset($_POST['estado'])){echo "value='".$_POST['estado']."'";} ?>>

    <?php if (isset($erro_estado)){ ?>
    <div class="erro">
        <?php echo $erro_estado; ?>
    </div>
    <?php } ?>
</div>

    <div class="col me-5">
    <label for="pais" class="form-label fw-bold">País</label>
    <input <?php if(isset($erro_geral) or isset($erro_pais)){echo 'class="form-control border-danger"' ;} ?> type="text" class="form-control border-dark" name="pais" id="pais" placeholder="Ex: Brasil" aria-label="pais" value="" <?php if (isset($_POST['pais'])){echo "value='".$_POST['pais']."'";} ?>>

    <?php if (isset($erro_pais)){ ?>
    <div class="erro">
    <?php echo $erro_pais; ?>
        </div>
        <?php } ?>
    </div>
</div>

<div class="row mt-5">
    <div class="col ms-5">
        <label for="foto" class="form-label fw-bold">Enviar foto de perfil</label>
        <input <?php if(isset($erro_geral) or isset($erro_foto)){echo 'class="form-control border-danger"' ;} ?> class="form-control border-dark" name="foto" type="file" id="foto">

        <?php if (isset($erro_foto)){ ?>
        <div class="erro">
        <?php echo $erro_foto; ?>
        </div>
        <?php } ?>

    </div>

    

    <div class="col ms-5 mt-4">
    <button type="submit" name="enviar" class="btn btn-primary btn-lg w-25 fs-3 ">Enviar</button>
    </div>
    </div>
    </form>

    <br><br><br><br><br><br>

    <script type="text/javascript" >
    $(document).ready(function(){
	$("#cep").mask("99999-999");
    });
    </script>

<script>
    $.noConflict();
    jQuery(document).ready(function(){
        jQuery("#cep").blur(function(){
        var valor = $(this).val();
        jQuery.get("https://viacep.com.br/ws/"+valor+"/json/", function(dados, status){
            
            jQuery("#cidade").val(dados.localidade);
            jQuery("#estado").val(dados.uf);
            jQuery("#endereco").val(dados.logradouro);
            jQuery("#bairro").val(dados.bairro);
            jQuery("#pais").val("Brasil");

        });
    });
    });

</script>;


  

</body>

</html>