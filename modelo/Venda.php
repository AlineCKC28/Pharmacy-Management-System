<?php 
include 'Conexao.php';
class Venda{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function Criar($nome,$dni,$total,$datta,$vendedor){
        $sql="INSERT INTO venda(datta,cliente,dni,total,vendedor) values(:datta,:cliente,:dni,:total,:vendedor)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':datta'=>$datta,':cliente'=>$nome,':dni'=>$dni,':total'=>$total,':vendedor'=>$vendedor));
    }
    function ultima_venda(){
        $sql="SELECT MAX(id_venda) as ultima_venda FROM venda";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function apagar($id_venda){
        $sql="DELETE FROM venda where id_venda=:id_venda";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venda'=>$id_venda));   
    }
}
?>