<?php 
include 'Conexao.php';
class Tipo{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function crear($nome){
        $sql="SELECT id_tip_prod FROM tipo_produto where nome=:nome";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nome'=>$nome));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO tipo_produto(nome) values (:nome)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome));
            echo 'add';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM tipo_produto where nome LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM tipo_produto where nome NOT LIKE '' ORDER BY id_tip_prod LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function apagar($id){
        $sql="DELETE FROM tipo_produto where id_tip_prod=:id";
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
        $sql="UPDATE tipo_produto SET nome=:nome where id_tip_prod=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nome'=>$nome));
        echo 'edit';
    }
    function preencher_tipos(){
        $sql="SELECT * FROM tipo_produto  order by nome asc";
            $query = $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
    }
}
?>