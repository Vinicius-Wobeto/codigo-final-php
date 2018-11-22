  <?php
  require_once "config/conexaobanco.class.php";

  class EscolinhaDAO{ //DAO -> DATA ACCESS OBJECT

    private $conexao = null;

    public function __construct(){
      $this->conexao = ConexaoBanco::getInstance();
    }

    public function __destruct(){}

    public function cadastrarJogador($esc){
      try{ //$statement
        $stat = $this->conexao->prepare(
          "insert into jogador(
           idJogador,nomeJogador,idadeJogador,pernaDominante,altura,posicao,peso)
           values(null,?,?,?,?,?,?)");
        $stat->bindValue(1, $esc->nomeJogador);
        $stat->bindValue(2, $esc->idadeJogador);
        $stat->bindValue(3, $esc->pernaDominante);
        $stat->bindValue(4, $esc->altura);
        $stat->bindValue(5, $esc->posicao);
        $stat->bindValue(6, $esc->peso);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao cadastrar jogador! ".$e;
      }//fecha catch
    }//fecha método
    public function cadastrarSocio($esc){
      try{ //$statement
        $stat = $this->conexao->prepare(
          "insert into socio(
           idSocio,nomeSocio,telefoneSocio,enderecoSocio,estadoCivil,sexo,cpf)
           values(null,?,?,?,?,?,?)");
        $stat->bindValue(1, $esc->nomeSocio);
        $stat->bindValue(2, $esc->telefoneSocio);
        $stat->bindValue(3, $esc->enderecoSocio);
        $stat->bindValue(4, $esc->estadoCivil);
        $stat->bindValue(5, $esc->sexo);
        $stat->bindValue(6, $esc->cpf);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao cadastrar socio! ".$e;
      }//fecha catch
    }
    public function cadastrarPatrocinio($esc){
      try{ //$statement
        $stat = $this->conexao->prepare(
          "insert into patrocinador(
           idPatrocinador,nomeEmpresa,CNPJ,enderecoPatrocinio)
           values(null,?,?,?)");
        $stat->bindValue(1, $esc->nomeEmpresa);
        $stat->bindValue(2, $esc->CNPJ);
        $stat->bindValue(3, $esc->enderecoPatrocinio);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao cadastrar patrocinador! ".$e;
      }//fecha catch
    }
    public function buscarJogador(){
      try{
        $stat= $this->conexao->query("select * from jogador");
        $array = $stat->fetchALL(PDO::FETCH_CLASS,"Escolinha");
        return $array;
      } catch (\Exception $e) {
        echo "Erro ao buscar jogador";
      }

    }
    public function buscarSocio(){
      try{
        $stat= $this->conexao->query("select * from socio");
        $array = $stat->fetchALL(PDO::FETCH_CLASS,"Escolinha");
        return $array;
      } catch (\Exception $e) {
        echo "Erro ao buscar socio";
      }

    }
    public function buscarPatrocinador(){
      try{
        $stat= $this->conexao->query("select * from patrocinador");
        $array = $stat->fetchALL(PDO::FETCH_CLASS,"Escolinha");
        return $array;
      } catch (\Exception $e) {
        echo "Erro ao buscar patrocinio";
      }
    }
      public function deletarJogador($id){
     try{
       $stat = $this->conexao->prepare("delete from jogador where idjogador = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir jogador! ".$e;
     }//fecha catch
   }//fecha deletarjogador
   public function deletarPatrocinador($id){
  try{
    $stat = $this->conexao->prepare("delete from patrocinador where idpatrocinador = ?");
    $stat->bindValue(1, $id);
    $stat->execute();
  }catch(PDOException $e){
    echo "Erro ao excluir patrocinador! ".$e;
  }//fecha catch
  }
  public function deletarSocio($id){
  try{
   $stat = $this->conexao->prepare("delete from socio where idsocio = ?");
   $stat->bindValue(1, $id);
   $stat->execute();
  }catch(PDOException $e){
   echo "Erro ao excluir sócio! ".$e;
  }//fecha catch
  }
  public function filtrarJogador($filtro, $pesquisa){
   try{
     $query = "";
     switch($filtro){
       case "codigo": $query = "where idjogador = ".$pesquisa;
       break;
       case "nome": $query="where nomeJogador like '%".$pesquisa."%'";
       break;
       case "idade": $query="where idadeJogador like '%".$pesquisa."%'";
       break;
       case "pernadominante": $query="where pernaDominante like '%".$pesquisa."%'";
       break;
       case "altura": $query="where altura like '%".$pesquisa."%'";
       break;
       case "peso": $query="where peso like '%".$pesquisa."%'";
       break;
       case "posicao": $query="where posicao like '%".$pesquisa."%'";
       break;
     }//fecha switch

     if(empty($pesquisa)){
       $query = "";
     }

     $stat=$this->conexao->query("select * from jogador ".$query);
     $array=$stat->fetchAll(PDO::FETCH_CLASS, "Escolinha");
     return $array;
   }catch(PDOException $e){
     echo "Erro ao filtrar! ".$e;
   }//fecha catch
 }//fecha filtrar
 public function filtrarSocio($filtro, $pesquisa){
  try{
    $query = "";
    switch($filtro){
      case "codigo": $query = "where idSocio = ".$pesquisa;
      break;
      case "nome": $query="where nomeSocio like '%".$pesquisa."%'";
      break;
      case "telefone": $query="where telefoneSocio like '%".$pesquisa."%'";
      break;
      case "endereco": $query="where enderecoSocio like '%".$pesquisa."%'";
      break;
      case "estadocivil": $query="where estadoCivil like '%".$pesquisa."%'";
      break;
      case "sexo": $query="where sexo like '%".$pesquisa."%'";
      break;
      case "cpf": $query="where cpf like '%".$pesquisa."%'";
      break;
    }//fecha switch

    if(empty($pesquisa)){
      $query = "";
    }

    $stat=$this->conexao->query("select * from socio ".$query);
    $array=$stat->fetchAll(PDO::FETCH_CLASS, "Escolinha");
    return $array;
  }catch(PDOException $e){
    echo "Erro ao filtrar! ".$e;
  }//fecha catch
}//fecha filtrar
public function filtrarPatrocinador($filtro, $pesquisa){
 try{
   $query = "";
   switch($filtro){
     case "codigo": $query = "where idPatrocinador = ".$pesquisa;
     break;
     case "nome": $query="where nomeEmpresa like '%".$pesquisa."%'";
     break;
     case "cnpj": $query="where CNPJ like '%".$pesquisa."%'";
     break;
     case "endereco": $query="where enderecoPatrocinio like '%".$pesquisa."%'";
     break;
   }//fecha switch

   if(empty($pesquisa)){
     $query = "";
   }

   $stat=$this->conexao->query("select * from patrocinador ".$query);
   $array=$stat->fetchAll(PDO::FETCH_CLASS, "Escolinha");
   return $array;
 }catch(PDOException $e){
   echo "Erro ao filtrar! ".$e;
 }//fecha catch
}//fecha filtrar
public function alterarJogador($esc){
      try{
        $stat = $this->conexao->prepare("update jogador set nomejogador=?, idadejogador=?, pernadominante=?, altura=?, peso=?, posicao=? where idJogador=?" );
        $stat->bindValue(1,$esc->nomeJogador);
        $stat->bindValue(2,$esc->idadeJogador);
        $stat->bindValue(3,$esc->pernaDominante);
        $stat->bindValue(4,$esc->altura);
        $stat->bindValue(5,$esc->peso);
        $stat->bindValue(6,$esc->posicao);
        $stat->bindValue(7,$esc->idJogador);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao alterar jogador! ".$e;
      }//fecha catch
  }//fecha método
  public function alterarPatrocinador($esc){
        try{
          $stat = $this->conexao->prepare(
            "update patrocinador set nomeempresa=?,cnpj=?,enderecoPatrocinio=? where idPatrocinador=?" );
          $stat->bindValue(1,$esc->nomeEmpresa);
          $stat->bindValue(2,$esc->CNPJ);
          $stat->bindValue(3,$esc->enderecoPatrocinio);
          $stat->bindValue(4,$esc->idPatrocinador);
          $stat->execute();
        }catch(PDOException $e){
          echo "Erro ao alterar Patrocinador! ".$e;
        }//fecha catch
    }//fecha método
    public function alterarSocio($esc){
          try{
            $stat = $this->conexao->prepare(
              "update socio set nomesocio=?, telefonesocio=?, enderecosocio=?, estadocivil=?, sexo=?, cpf=? where idsocio=?" );
            $stat->bindValue(1,$esc->nomeSocio);
            $stat->bindValue(2,$esc->telefoneSocio);
            $stat->bindValue(3,$esc->enderecoSocio);
            $stat->bindValue(4,$esc->estadoCivil);
            $stat->bindValue(5,$esc->sexo);
            $stat->bindValue(6,$esc->cpf);
            $stat->bindValue(7,$esc->idSocio);

            $stat->execute();
          }catch(PDOException $e){
            echo "Erro ao alterar Socio! ".$e;
          }//fecha catch
      }//fecha método
}
