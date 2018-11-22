<?php
require_once "config/conexaobanco.class.php";

class SocioDAO{ //DAO -> DATA ACCESS OBJECT

  private $conexao = null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct(){}

  public function cadastrarSocio($soc){
    try{ //$statement
      $stat = $this->conexao->prepare(
        "insert into socio(
         idSocio,nomeSocio,telefoneSocio,enderecoSocio,estadoCivil,sexo,cpf)
         values(null,?,?,?,?,?,?)");
      $stat->bindValue(1, $soc->nomeSocio);
      $stat->bindValue(2, $soc->telefoneSocio);
      $stat->bindValue(3, $soc->enderecoSocio);
      $stat->bindValue(4, $soc->estadoCivil);
      $stat->bindValue(5, $soc->sexo);
      $stat->bindValue(6, $soc->cpf);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao cadastrar socio! ".$e;
    }//fecha catch
  }

  public function buscarSocio(){
    try{
      $stat= $this->conexao->query("select * from socio");
      $array = $stat->fetchALL(PDO::FETCH_CLASS,"Socio");
      return $array;
    } catch (\Exception $e) {
      echo "Erro ao buscar socio";
    }

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
  $array=$stat->fetchAll(PDO::FETCH_CLASS, "Socio");
  return $array;
}catch(PDOException $e){
  echo "Erro ao filtrar! ".$e;
}//fecha catch
}//fecha filtrar

  public function alterarSocio($soc){
        try{
          $stat = $this->conexao->prepare(
            "update socio set nomesocio=?, telefonesocio=?, enderecosocio=?, estadocivil=?, sexo=?, cpf=? where idsocio=?" );
          $stat->bindValue(1,$soc->nomeSocio);
          $stat->bindValue(2,$soc->telefoneSocio);
          $stat->bindValue(3,$soc->enderecoSocio);
          $stat->bindValue(4,$soc->estadoCivil);
          $stat->bindValue(5,$soc->sexo);
          $stat->bindValue(6,$soc->cpf);
          $stat->bindValue(7,$soc->idSocio);

          $stat->execute();
        }catch(PDOException $e){
          echo "Erro ao alterar Socio! ".$e;
        }//fecha catch
    }//fecha método
    public function gerarJSON($filtro, $pesquisa){
    try{
      $query="";
      switch($filtro){
        case "codigo":
        $query = "where idlivro = ".$pesquisa;
        break;
      }
      $stat = $this->conexao->query("select * from socio ".$query);
      return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    }catch(PDOException $e){
      echo "Erro ao gerar JSON! ".$e;
    }//fecha catch
  }//fecha gerarJSON
}
