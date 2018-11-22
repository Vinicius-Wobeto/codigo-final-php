<?php
class Jogador{

  private $idJogador;
  private $nomeJogador;
  private $idadeJogador;
  private $pernaDominante;
  private $altura;
  private $peso;
  private $posicao;




  public function __construct(){}
  public function __destruct(){}

  public function __get($a){ return $this->$a;}
  public function __set($a,$v){ $this->$a = $v;}

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
