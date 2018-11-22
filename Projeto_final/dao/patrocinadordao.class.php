<?php
require_once "config/conexaobanco.class.php";

class PatrocinadorDAO{ //DAO -> DATA ACCESS OBJECT

  private $conexao = null;

  public function __construct(){
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct(){}

  public function cadastrarPatrocinio($pat){
    try{ //$statement
      $stat = $this->conexao->prepare(
        "insert into patrocinador(
         idPatrocinador,nomeEmpresa,CNPJ,enderecoPatrocinio)
         values(null,?,?,?)");
      $stat->bindValue(1, $pat->nomeEmpresa);
      $stat->bindValue(2, $pat->CNPJ);
      $stat->bindValue(3, $pat->enderecoPatrocinio);
      $stat->execute();
    }catch(PDOException $e){
      echo "Erro ao cadastrar patrocinador! ".$e;
    }//fecha catch
  }


  public function buscarPatrocinador(){
    try{
      $stat= $this->conexao->query("select * from patrocinador");
      $array = $stat->fetchALL(PDO::FETCH_CLASS,"Patrocinador");
      return $array;
    } catch (\Exception $e) {
      echo "Erro ao buscar patrocinio";
    }
  }

 public function deletarPatrocinador($id){
try{
  $stat = $this->conexao->prepare("delete from patrocinador where idpatrocinador = ?");
  $stat->bindValue(1, $id);
  $stat->execute();
}catch(PDOException $e){
  echo "Erro ao excluir patrocinador! ".$e;
}//fecha catch
}


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
 $array=$stat->fetchAll(PDO::FETCH_CLASS, "Patrocinador");
 return $array;
}catch(PDOException $e){
 echo "Erro ao filtrar! ".$e;
}//fecha catch
}//fecha filtrar
public function alterarPatrocinador($pat){
      try{
        $stat = $this->conexao->prepare(
          "update patrocinador set nomeempresa=?,cnpj=?,enderecoPatrocinio=? where idPatrocinador=?" );
        $stat->bindValue(1,$pat->nomeEmpresa);
        $stat->bindValue(2,$pat->CNPJ);
        $stat->bindValue(3,$pat->enderecoPatrocinio);
        $stat->bindValue(4,$pat->idPatrocinador);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao alterar Patrocinador! ".$e;
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
    $stat = $this->conexao->query("select * from patrocinador ".$query);
    return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
  }catch(PDOException $e){
    echo "Erro ao gerar JSON! ".$e;
  }//fecha catch
}//fecha gerarJSON

}
