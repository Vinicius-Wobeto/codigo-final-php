<?php
include_once "dao/jogadordao.class.php";
include_once "modelo/jogador.class.php";

//localhost/tarde/cadlivro/gerar-json-livro.php
$jogDAO = new JogadorDAO();
if(isset($_GET['id'])){
  echo $jogDAO->gerarJSON("codigo", $_GET['id']);
}else{
  echo $jogDAO->gerarJSON("","");
}
