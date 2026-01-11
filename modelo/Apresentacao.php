<?php 
include 'Conexao.php';
class Apresentacao{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function crear($nome){
        $sql="SELECT id_apresentacao FROM apresentacao where nome=:nome";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nome'=>$nome));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO apresentacao(nome) values (:nome)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome));
            echo 'add';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM apresentacao where nome LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM apresentacao where nome NOT LIKE '' ORDER BY id_apresentacao LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function apagar($id){
        $sql="DELETE FROM apresentacao where id_apresentacao=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        echo 'apagado';
        if(!empty( $query->execute(array(':id'=>$id)))){
        }
        else{
            echo 'nãoapagado';
        }
    }
    function editar($nome,$id_editado){
        $sql="UPDATE apresentacao SET nome=:nome where id_apresentacao=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nome'=>$nome));
        echo 'edit';
    }
    function preencher_apresentacoes(){
        $sql="SELECT * FROM apresentacao  order by nome asc";
            $query = $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
    }
}
?>