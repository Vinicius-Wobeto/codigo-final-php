<?php
class Escolinha{

  private $idJogador;
  private $nomeJogador;
  private $idadeJogador;
  private $pernaDominante;
  private $altura;
  private $peso;
  private $posicao;

  private $idSocio;
  private $nomeSocio;
  private $telefoneSocio;
  private $enderecoSocio;
  private $estadoCivil;
  private $sexo;
  private $cpf;

  private $idPatrocinador;
  private $nomeEmpresa;
  private $CNPJ;
  private $enderecoPatrocinio;


  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a;}
  public function __set($a,$v){ $this->$a = $v;}


  public function mostrarSocio(){
    return nl2br("
                  Nome: $this->nomeSocio
                  Telefone: $this->telefoneSocio
                  Endereço: $this->enderecoSocio
                  Estado civil: $this->estadoCivil
                  Sexo: $this->sexo
                  CPF: $this->cpf");
}
public function mostrarPatrocinador(){
  return nl2br("
                Nome: $this->nomeEmpresa
                CNPJ: $this->CNPJ
                Endereço: $this->enderecoPatrocinio");
}
  public function __toString(){
    return nl2br("
                  Nome: $this->nomeJogador
                  Idade: $this->idadeJogador
                  Perna Dominante: $this->pernaDominante
                  Altura: $this->altura
                  Posição: $this->posicao
                  Peso: $this->peso");
  }
}
