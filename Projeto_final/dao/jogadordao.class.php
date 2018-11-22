  <?php
  require_once "config/conexaobanco.class.php";

  class JogadorDAO{ //DAO -> DATA ACCESS OBJECT

    private $conexao = null;

    public function __construct(){
      $this->conexao = ConexaoBanco::getInstance();
    }

    public function __destruct(){}

    public function cadastrarJogador($jog){
      try{ //$statement
        $stat = $this->conexao->prepare(
          "insert into jogador(
           idJogador,nomeJogador,idadeJogador,pernaDominante,altura,posicao,peso)
           values(null,?,?,?,?,?,?)");
        $stat->bindValue(1, $jog->nomeJogador);
        $stat->bindValue(2, $jog->idadeJogador);
        $stat->bindValue(3, $jog->pernaDominante);
        $stat->bindValue(4, $jog->altura);
        $stat->bindValue(5, $jog->posicao);
        $stat->bindValue(6, $jog->peso);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao cadastrar jogador! ".$e;
      }//fecha catch
    }//fecha método
    public function buscarJogador(){
      try{
        $stat= $this->conexao->query("select * from jogador");
        $array = $stat->fetchALL(PDO::FETCH_CLASS,"Jogador");
        return $array;
      } catch (\Exception $e) {
        echo "Erro ao buscar jogador";
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
     $array=$stat->fetchAll(PDO::FETCH_CLASS, "Jogador");
     return $array;
   }catch(PDOException $e){
     echo "Erro ao filtrar! ".$e;
   }//fecha catch
 }//fecha filtrar

public function alterarJogador($jog){
      try{
        $stat = $this->conexao->prepare("update jogador set nomejogador=?, idadejogador=?, pernadominante=?, altura=?, peso=?, posicao=? where idJogador=?" );
        $stat->bindValue(1,$jog->nomeJogador);
        $stat->bindValue(2,$jog->idadeJogador);
        $stat->bindValue(3,$jog->pernaDominante);
        $stat->bindValue(4,$jog->altura);
        $stat->bindValue(5,$jog->peso);
        $stat->bindValue(6,$jog->posicao);
        $stat->bindValue(7,$jog->idJogador);
        $stat->execute();
      }catch(PDOException $e){
        echo "Erro ao alterar jogador! ".$e;
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
      $stat = $this->conexao->query("select * from jogador ".$query);
      return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
    }catch(PDOException $e){
      echo "Erro ao gerar JSON! ".$e;
    }//fecha catch
  }//fecha gerarJSON
}
