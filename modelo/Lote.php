<?php 
include 'Conexao.php';
class Lote{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function criar($id_produto,$fornecedor,$stock,$vencimento){
        $sql="INSERT INTO lote(stock,vencimento,lote_id_prod,lote_id_forne) values (:stock,:vencimento,:id_produto,:id_fornecedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':stock'=>$stock,':vencimento'=>$vencimento,':id_produto'=>$id_produto,':id_fornecedor'=>$fornecedor));
        $this->objetos=$query->fetchall();
        echo 'add';
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT id_lote,stock, vencimento, concentracao, adicional, produto.nome as prod_nom, laboratorio.nome as lab_nom, tipo_produto.nome as tip_nom,apresentacao.nome as apre_nom, fornecedor.nome as fornecedor, produto.avatar as logo FROM lote 
            JOIN fornecedor on lote_id_forne=id_fornecedor
            JOIN produto on lote_id_prod=id_produto
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_produto on prod_tip_prod=id_tip_prod
            JOIN apresentacao on prod_apresent=id_apresentacao and produto.nome  LIKE :consulta ORDER BY produto.nome LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT id_lote,stock, vencimento, concentracao, adicional, produto.nome as prod_nom, laboratorio.nome as lab_nom, tipo_produto.nome as tip_nom,apresentacao.nome as apre_nom, fornecedor.nome as fornecedor, produto.avatar as logo FROM lote 
            JOIN fornecedor on lote_id_forne=id_fornecedor
            JOIN produto on lote_id_prod=id_produto
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_produto on prod_tip_prod=id_tip_prod
            JOIN apresentacao on prod_apresent=id_apresentacao and produto.nome not LIKE '' ORDER BY produto.nome LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function editar($id,$stock){
        $sql="UPDATE lote SET stock=:stock where id_lote=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':stock'=>$stock));
        echo 'edit';
    }
    function apagar($id){
        $sql="DELETE FROM lote where id_lote=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'apagado';
        }
        else{
            echo 'não apagado';
        }
    }
 }
    ?>  