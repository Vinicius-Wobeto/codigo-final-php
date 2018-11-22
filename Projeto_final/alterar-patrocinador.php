<?php
session_start();
ob_start(); //buffer
if(isset($_GET['id'])){
    include_once "modelo/patrocinador.class.php";
    include_once "dao/patrocinadordao.class.php";
    $patDAO = new PatrocinadorDAO();
    $array = $patDAO->filtrarPatrocinador("codigo",$_GET['id']);
    //só para teste
    //var_dump($array);
    $pat = $array[0];
    //echo $liv;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Patrocinador</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-primary">Alteração de Patrocinador</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Sistema</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="cadastro-patrocinador.php">Cad. Patrocinador <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="consulta-patrocinador.php">Cons. Patrocinador <span class="sr-only"></span></a>
              </li>
              <?php
              if(isset($_SESSION['privateUser'])){
                include_once "modelo/usuario.class.php";
                $u = unserialize($_SESSION['privateUser']);
                if($u->tipo == "adm"){
              ?>
                  <li class="nav-item">
                    <a class="nav-link" href="consulta-patrocinador.php">Cons. Patrocinador <span class="sr-only"></span></a>
                  </li>
              <?php
                }
              }
              ?>
            </ul>
          </div>
        </nav>

        <form name="alterarpatrocinador" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnomeEmpresa"
            placeholder="Nome" class="form-control"
            value="<?php if(isset($pat)){ echo $pat->nomeEmpresa; } ?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcnpj" placeholder="CNPJ" class="form-control"
            value="<?php if(isset($pat)){ echo $pat->CNPJ; } ?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereço" class="form-control"
            value="<?php if(isset($pat)){ echo $pat->enderecoPatrocinio; } ?>">
          </div>

          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>

        <?php
        if(isset($_SESSION['msg'])){
          echo "<h2>".$_SESSION['msg']."</h2>";
          unset($_SESSION['msg']);
        }
        ?>

        <?php
        if(isset($_POST['alterar'])){
          include_once "modelo/patrocinador.class.php";
          include_once "dao/patrocinadordao.class.php";
          include_once "util/padronizacao.class.php";

          $pat= new Patrocinador();
          $pat->idPatrocinador=$_GET['id'];
          $pat->nomeEmpresa=Padronizacao::converterMainMin($_POST['txtnomeEmpresa']);
          $pat->CNPJ= $_POST['txtcnpj'];
          $pat->enderecoPatrocinio=Padronizacao::converterMainMin($_POST['txtendereco']);


          $patDAO = new PatrocinadorDAO();
          $patDAO->alterarPatrocinador($pat);

          // echo "Livro cadastrado com sucesso!";
          // echo $liv; //mostrando o toString

          $_SESSION['msg'] = "Patrocinador alterado com sucesso!";
          header("location:consulta-patrocinador.php");
        }
        ?>
      </div>
  </body>
</html>
