<?php
session_start();
ob_start(); //buffer
if(isset($_GET['id'])){
    include_once "modelo/socio.class.php";
    include_once "dao/sociodao.class.php";
    $socDAO = new SocioDAO();
    $array = $socDAO->filtrarSocio("codigo",$_GET['id']);
    //só para teste
    //var_dump($array);
    $soc = $array[0];
    //echo $liv;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Sócio</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-primary">Alteração de Sócio</h1>

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
                <a class="nav-link" href="cadastro-socio.php">Cad. Socio <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="consulta-socio.class.php">Cons. Socio <span class="sr-only"></span></a>
              </li>
              <?php
              if(isset($_SESSION['privateUser'])){
                include_once "modelo/usuario.class.php";
                $u = unserialize($_SESSION['privateUser']);
                if($u->tipo == "adm"){
              ?>
                  <li class="nav-item">
                    <a class="nav-link" href="consulta-socio.php">Cons. Socio <span class="sr-only"></span></a>
                  </li>
              <?php
                }
              }
              ?>
            </ul>
          </div>
        </nav>

        <form name="alterarsocio" method="post" action="">
          <div class="form-group">
            <input type="text" class="form-control" name="txtnomesocio" placeholder="Nome" value="<?php if (isset($soc)) {echo $soc->nomeSocio;} ?>">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="txttelefonesocio" placeholder="Telefone" value="<?php if (isset($soc)) {echo $soc->telefoneSocio;} ?>">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="txtenderecosocio" placeholder="Endereço" value="<?php if (isset($soc)) {echo $soc->enderecoSocio;} ?>">
          </div>
          <div class="form-group">
            <label><input type="radio" name="rdestadoCivil" class="form-control" value="Solteiro" <?php if(isset($soc)){if($soc->estadoCivil == "Solteiro"){echo "checked='checked'";}}?>>Solteiro</label>
            <label><input type="radio" name="rdestadoCivil" class="form-control" value="Casado" <?php if(isset($soc)){if($soc->estadoCivil == "Casado"){echo "checked='checked'";}}?>>Casado</label>
          </div>

          <div class="form-group">
            <select class="form-control" name="selsexo">
              <option value="Masculino"<?php if (isset($soc)) {if ($soc->sexo=="Masculino") {echo "checked='checked'";}}?>>Masculino</option>
              <option value="Feminino"<?php if (isset($soc)) {if ($soc->sexo=="Feminino") {echo "checked='checked'";}}?>>Feminino</option>
            </select>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="txtcpf" placeholder="CPF" value="<?php if (isset($soc)) {echo $soc->cpf;} ?>">
          </div>

          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
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
        if(isset($_POST['alterar'])){
          include_once "modelo/socio.class.php";
          include_once "dao/sociodao.class.php";
          include_once "util/padronizacao.class.php";

          $soc= new Socio();
          $soc->idSocio=$_GET['id'];
          $soc->nomeSocio=Padronizacao::converterMainMin($_POST['txtnomesocio']);
          $soc->telefoneSocio=$_POST['txttelefonesocio'];
          $soc->enderecoSocio=Padronizacao::converterMainMin($_POST['txtenderecosocio']);
          $soc->estadoCivil=Padronizacao::converterMainMin($_POST['rdestadoCivil']);
          $soc->sexo=Padronizacao::converterMainMin($_POST['selsexo']);
          $soc->cpf=$_POST['txtcpf'];



          $socDAO = new SocioDAO();
          $socDAO->alterarSocio($soc);

          header("location:consulta-socio.class.php");
        }
        ?>
      </div>
  </body>
</html>
