<?php
session_start();
ob_start(); //buffer
if(isset($_GET['id'])){
    include_once "modelo/jogador.class.php";
    include_once "dao/jogadordao.class.php";
    $jogDAO = new JogadorDAO();
    $array = $jogDAO->filtrarJogador("codigo",$_GET['id']);
    //só para teste
    //var_dump($array);
    $jog = $array[0];
    //echo $esc;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alteração de Jogador</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-primary">Alteração de Jogador</h1>
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
                <a class="nav-link" href="cadastro-jogador.php">Cad. Jogador <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="consulta-jogador.class.php">Cons. Jogador <span class="sr-only"></span></a>
              </li>
              <?php
              if(isset($_SESSION['privateUser'])){
                include_once "modelo/usuario.class.php";
                $u = unserialize($_SESSION['privateUser']);
                if($u->tipo == "adm"){
              ?>
                  <li class="nav-item">
                    <a class="nav-link" href="consulta-jogador.class.php">Cons. Jogador <span class="sr-only"></span></a>
                  </li>
              <?php
                }
              }
              ?>
            </ul>
          </div>
        </nav>

        <form name="alterarjogador" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnomejogador"
            placeholder="Nome" class="form-control" value="<?php if(isset($jog)){ echo $jog->nomeJogador; } ?>">
          </div>

          <div class="form-group">
            <input type="text" name="txtidadejogador"
            placeholder="Nome" class="form-control" value="<?php if(isset($jog)){ echo $jog->idadeJogador; } ?>">
          </div>
          <div class="form-group">
            <label><input type="radio" name="rdperna" class="form-control" value="Destro" <?php if(isset($jog)){if($jog->pernaDominante == "Destro"){echo "checked='checked'";}}?>>Destro</label>
            <label><input type="radio" name="rdperna" class="form-control" value="Canhoto" <?php if(isset($jog)){if($jog->pernaDominante == "Canhoto"){echo "checked='checked'";}}?>>Canhoto</label>
           <label><input type="radio" name="rdperna" class="form-control" value="Ambidestro" <?php if(isset($jog)){if($jog->pernaDominante == "Ambidestro"){echo "checked='checked'";}}?>>Ambidestro</label>
          <div class="form-group">
            <input type="text" name="txtaltura" class="form-control" value="<?php if(isset($jog)){ echo $jog->altura; } ?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtpeso" class="form-control" value="<?php if(isset($jog)){ echo $jog->peso; } ?>">
          </div>
          <div class="from-group">
            <select name="selposicao" class="form-control" >
              <option value="Goleiro" <?php if (isset($jog)) {
                      if ($jog->posicao=="Goleiro"){
                        echo "selected='selected'";
                      }
              } ?>>Goleiro</option>
              <option value="Zagueiro" <?php if(isset($jog)){
                              if($jog->posicao == "Zagueiro"){
                                echo "selected='selected'";
                              }
                            } ?>>Zagueiro</option>
              <option value="Lateral" <?php if(isset($jog)){
                              if($jog->posicao == "Lateral"){
                                echo "selected='selected'";
                            }
                          } ?>>Lateral</option>
              <option value="Volante" <?php if(isset($jog)){
                              if($jog->posicao == "Volante"){
                                echo "selected='selected'";
                            }
                          } ?>>Volante</option>
              <option value="Meio-campo" <?php if(isset($jog)){
                              if($jog->posicao == "Meio-campo"){
                                echo "selected='selected'";
                              }
                            } ?>>Meio-campo</option>
              <option value="Atacante" <?php if(isset($jog)){
                              if($jog->posicao == "Atacante"){
                                echo "selected='selected'";
                              }
                            } ?>>Atacante</option>
            </select>
          </div>
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
          include_once "modelo/jogador.class.php";
          include_once "dao/jogadordao.class.php";
          include_once "util/padronizacao.class.php";

          $jog= new Jogador();
          $jog->idJogador=$_GET['id'];
          $jog->nomeJogador=Padronizacao::converterMainMin($_POST['txtnomejogador']);
          $jog->idadeJogador=$_POST['txtidadejogador'];
          $jog->pernaDominante=Padronizacao::converterMainMin($_POST['rdperna']);
          $jog->altura=$_POST['txtaltura'];
          $jog->peso=$_POST['txtpeso'];
          $jog->posicao=Padronizacao::converterMainMin($_POST['selposicao']);

          $jogDAO = new JogadorDAO();
          $jogDAO->alterarJogador($jog);

          header("location:consulta-jogador.class.php");
        }
        ?>
      </div>
  </body>
</html>
