<?php
class Socio{

  private $idSocio;
  private $nomeSocio;
  private $telefoneSocio;
  private $enderecoSocio;
  private $estadoCivil;
  private $sexo;
  private $cpf;




  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a;}
  public function __set($a,$v){ $this->$a = $v;}

  public function __toString(){
    return nl2br("
                  Nome: $this->nomeSocio
                  Telefone: $this->telefoneSocio
                  Endereço: $this->enderecoSocio
                  Estado Civil: $this->estadoCivil
                  Sexo: $this->sexo
                  CPF: $this->cpf");
  }
}
