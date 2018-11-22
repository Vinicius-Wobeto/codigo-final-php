<?php
session_start();
ob_start();

if(!isset($_SESSION['privateUser'])){
  $_SESSION['msg'] = "Você precisa estar logado para visualizar essa página!";
  header("location:sistema.php");
}
include_once "dao/sociodao.class.php";
include_once "modelo/socio.class.php";

$socDAO = new SocioDAO;
$array = $socDAO->buscarSocio();
 ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Consulta de sócio</title>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
<script src="vendor/components/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
      <h1 class="jumbotron bg-primary">Consulta de sócio</h1>

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
              <a class="nav-link" href="cadastro-socio.php">Cad. Sócio <span class="sr-only"></span></a>
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
        if (isset($array)) {
          if (count($array)==0) {
            echo "<h3>Não há socios no banco de dados</h3>";
            return;
          }
        }
       ?>
       <form name="pesquisa" action="" method="post">
         <div class="row">
           <div class="form-group col-md-6">
             <input type="text" name="txtfiltro" placeholder="Digite sua pesquisa"class="form-control">
           </div>
           <div class="form-group col-md-6">
             <select class="form-control" name="selfiltro">
               <option value="todos">Todos</option>
               <option value="codigo">Código</option>
               <option value="nome">Nome</option>
               <option value="telefone">Telefone</option>
               <option value="endereco">Endereço</option>
               <option value="estadocivil">Estado civil</option>
               <option value="sexo">Sexo</option>
               <option value="cpf">CPF</option>
             </select>
           </div>
         </div>
         <div class="form-group">
            <input type="submit" name="filtrar" value="Filtrar" class="btn btn-primary">
          </div>
       </form>
       <?php
        if (isset($_POST['filtrar'])) {
          $array = $socDAO->filtrarSocio($_POST['selfiltro'],$_POST['txtfiltro']);
        }
        ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
              <tr>

                <th>Código</th>
                <th>Nome do sócio</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Estado civil</th>
                <th>Sexo</th>
                <th>CPF</th>
                <th>Alterar</th>
                <th>Excluir</th>
              </tr>
            </thead>
            <tfoot>
              <tr>

                <th>Código</th>
                <th>Nome do sócio</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Estado civil</th>
                <th>Sexo</th>
                <th>CPF</th>
                <th>Alterar</th>
                <th>Excluir</th>
              </tr>
            </tfoot>

            <tbody>
              <?php
            foreach($array as $soc){
              echo "<tr>";
                echo "<td>$soc->idSocio</td>";
                echo "<td>$soc->nomeSocio</td>";
                echo "<td>$soc->telefoneSocio</td>";
                echo "<td>$soc->enderecoSocio</td>";
                echo "<td>$soc->estadoCivil</td>";
                echo "<td>$soc->sexo</td>";
                echo "<td>$soc->cpf</td>";
                echo "<td><a href='alterar-socio.php?id=$soc->idSocio' class='btn btn-warning'>Alterar</a></td>";
                echo "<td><a href='consulta-socio.class.php?id=$soc->idSocio' class='btn btn-danger'>Excluir</a></td>";
              echo "</tr>";
            }
            ?>
          </tbody>
          <?php
       if(isset($_GET['id'])){
         $socDAO = new SocioDAO();
         $socDAO->deletarSocio($_GET['id']);
         header("location:consulta-socio.class.php");
       }
       ?>
    </div>
</body>
</html>
