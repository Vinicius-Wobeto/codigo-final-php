<?php
include_once "dao/sociodao.class.php";
include_once "modelo/socio.class.php";

//localhost/tarde/cadlivro/gerar-json-livro.php
$socDAO = new SocioDAO();
if(isset($_GET['id'])){
  echo $socDAO->gerarJSON("codigo", $_GET['id']);
}else{
  echo $socDAO->gerarJSON("","");
}
