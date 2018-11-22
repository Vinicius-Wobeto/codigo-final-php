<?php
session_start();
ob_start(); //buffer

if(!isset($_SESSION['privateUser'])){
  $_SESSION['msg'] = "Você precisa estar logado para visualizar essa página!";
  header("location:sistema.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Socio</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
  <style>
  #fundo{
    background: url(img/CAPA.jpg) no-repeat center center fixed;
    background-size: cover; /*Css padrão*/
    -webkit-background-size: cover; /*Safari e chrome*/
    -moz-background-size: cover; /*Firefox*/
    -ms-background-size: cover; /*Internet explorer*/
    -o-background-size: cover; /*Opera*/
  }

  </style>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-primary">Cadastro de Socio</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="sistema.php">Sistema</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Página inicial</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-socio.class.php">Cons. Socio<span class="sr-only">(current)</span></a>
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
        <?php
          if (isset($_SESSION['erros'])) {
            $erros = unserialize($_SESSION['erros']);
            foreach ($erros as $e){
              echo "<br>".$e;
            }
            unset($_SESSION['erros']);
          }

         ?>

         <?php
          if (isset($_SESSION['post'])) {
            $dados = unserialize($_SESSION['post']);
            unset($_SESSION['post']);
          }
          ?>
        <form name="cadsocio" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txttelefone" placeholder="Telefone" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereço" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf"placeholder="CPF"class="form-control">
          </div>
          <div class="form-group">
            <label><input type="radio" name="rdestadoCivil" value="Solteiro" class="form-control">Solteiro</label>
            <label><input type="radio" name="rdestadoCivil" value="Casado" class="form-control">Casado</label>
          </div>

          <div class="form-group">
            <select class="form-control" name="selsexo">
              <option value="masculino">Masculino</option>
              <option value="feminino">feminino</option>
            </select>
          </div>


          <div class="form-group">
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
          </div>
        </form>

        <?php
        if(isset($_SESSION['msg'])){
          echo "<h2>".$_SESSION['msg']."</h2>";
          unset($_SESSION['msg']);
        }
        ?>

        <?php
        if(isset($_POST['cadastrar'])){
          include_once "modelo/socio.class.php";
          include_once "dao/sociodao.class.php";
          include_once "util/padronizacao.class.php";
          include_once "util/validacao.class.php";

          $erros=array();
          if (!Validacao::validarNomes($_POST['txtnome'])) {
            $erros[]="Nome inválido";
          }
          if (!Validacao::validarTelefone($_POST['txttelefone'])) {
            $erros[]="Telefone inválido";
          }
          if (!Validacao::validarEndereco($_POST['txtendereco'])) {
            $erros[]="Endereço inválido";
          }
          if (!Validacao::validarCpf($_POST['txtcpf'])) {
            $erros[]="CPF inválido";
          }

          if (count($erros)==0) {
          $soc = new Socio();
          $soc->nomeSocio = Padronizacao::antiXSS(Padronizacao::converterMainMin($_POST['txtnome']));
          $soc->telefoneSocio =$_POST['txttelefone'];
          $soc->enderecoSocio = Padronizacao::antiXSS(Padronizacao::converterMainMin($_POST['txtendereco']));
          $soc->estadoCivil = Padronizacao::antiXSS(Padronizacao::converterMainMin($_POST['rdestadoCivil']));
          $soc->sexo = Padronizacao::antiXSS(Padronizacao::converterMainMin($_POST['selsexo']));
          $soc->cpf = $_POST['txtcpf'];

          $socDAO = new SocioDAO();
          $socDAO->cadastrarSocio($soc);
          $_SESSION['msg'] = "Socio cadastrado com sucesso!";
          header("location:cadastro-socio.php");
        }else{
          $_SESSION['erros']= serialize($erros);
          $_SESSION['post']=serialize($post);
          header("location:cadastro-socio.php");
        }
      }
        ?>
      </div>
  </body>
</html>
