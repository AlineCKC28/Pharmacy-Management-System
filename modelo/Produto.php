<?php 
include 'Conexao.php';
class Produto{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function criar($nome,$concentracao,$adicional,$preco,$laboratorio,$tipo,$apresentacao,$avatar){
        $sql="SELECT id_produto FROM produto where nome=:nome and concentracao=:concentracao and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_apresent=:apresentacao";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nome'=>$nome,':concentracao'=>$concentracao,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':tipo'=>$tipo,':apresentacao'=>$apresentacao));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO produto(nome,concentracao,adicional,preco,prod_lab,prod_tip_prod,prod_apresent,avatar) values (:nome,:concentracao,:adicional,:preco,:laboratorio,:tipo,:apresentacao,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome,':concentracao'=>$concentracao,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':tipo'=>$tipo,':apresentacao'=>$apresentacao,':preco'=>$preco,':avatar'=>$avatar));
            echo 'add';
        }
    }
    function editar($id,$nome,$concentracao,$adicional,$preco,$laboratorio,$tipo,$apresentacao){
        $sql="SELECT id_produto FROM produto where id_produto!=:id and nome=:nome and concentracao=:concentracao and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_apresent=:apresentacao";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nome'=>$nome,':concentracao'=>$concentracao,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':tipo'=>$tipo,':apresentacao'=>$apresentacao));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noedit';
        }
        else{
            $sql="UPDATE produto SET nome=:nome,concentracao=:concentracao, adicional=:adicional, prod_lab=:laboratorio, prod_tip_prod=:tipo, prod_apresent=:apresentacao,preco=:preco where id_produto=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':nome'=>$nome,':concentracao'=>$concentracao,':adicional'=>$adicional,':laboratorio'=>$laboratorio,':tipo'=>$tipo,':apresentacao'=>$apresentacao,':preco'=>$preco));
            echo 'edit';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT id_produto, produto.nome as nome, concentracao, adicional, preco, laboratorio.nome as laboratorio, tipo_produto.nome as tipo, apresentacao.nome as apresentacao, produto.avatar as avatar, prod_lab,prod_tip_prod,prod_apresent
            FROM produto
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_produto on prod_tip_prod=id_tip_prod
            JOIN apresentacao on prod_apresent=id_apresentacao and produto.nome LIKE :consulta LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT id_produto, produto.nome as nome, concentracao, adicional, preco, laboratorio.nome as laboratorio, tipo_produto.nome as tipo, apresentacao.nome as apresentacao, produto.avatar as avatar, prod_lab,prod_tip_prod,prod_apresent
            FROM produto
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_produto on prod_tip_prod=id_tip_prod
            JOIN apresentacao on prod_apresent=id_apresentacao and produto.nome not LIKE '' order by produto.nome LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function mudarlogo($id,$nome){
        $sql="UPDATE produto SET avatar=:nome where id_produto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nome'=>$nome));
    }
    function apagar($id){
        $sql="DELETE FROM produto where id_produto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'apagado';
        }
        else{
            echo 'não apagado';
        }
    }
    function obter_stock($id){
        $sql="SELECT SUM(stock) as total FROM lote where lote_id_prod=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function buscar_id($id){
        $sql="SELECT id_produto, produto.nome as nome, concentracao, adicional, preco, laboratorio.nome as laboratorio, tipo_produto.nome as tipo, apresentacao.nome as apresentacao, produto.avatar as avatar, prod_lab,prod_tip_prod,prod_apresent
            FROM produto
            JOIN laboratorio on prod_lab=id_laboratorio
            JOIN tipo_produto on prod_tip_prod=id_tip_prod
            JOIN apresentacao on prod_apresent=id_apresentacao where id_produto=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            $this->objetos=$query->fetchall();
            return $this->objetos;
    }
}
?>