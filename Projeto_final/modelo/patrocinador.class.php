<?php
class Patrocinador{

 private $idPatrocinador;
 private $nomeEmpresa;
 private $CNPJ;
 private $enderecoPatrocinio;



  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a;}
  public function __set($a,$v){ $this->$a = $v;}

  public function __toString(){
    return nl2br("
                  Nome: $this->nomeEmpresa
                  CNPJ: $this->CNPJ
                  Endereço: $this->enderecoPatrocinio");
  }
}
