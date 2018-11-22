<?php
include_once "dao/patrocinadordao.class.php";
include_once "modelo/patrocinador.class.php";

//localhost/tarde/cadlivro/gerar-json-livro.php
$patDAO = new PatrocinadorDAO();
if(isset($_GET['id'])){
  echo $patDAO->gerarJSON("codigo", $_GET['id']);
}else{
  echo $patDAO->gerarJSON("","");
}
