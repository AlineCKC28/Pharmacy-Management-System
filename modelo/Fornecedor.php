<?php 
include 'Conexao.php';
class Fornecedor{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function criar($nome,$telefone,$correio,$endereco,$avatar){
        $sql="SELECT id_fornecedor FROM fornecedor where nome=:nome";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nome'=>$nome));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO fornecedor(nome,telefone,correio,endereco,avatar) values (:nome,:telefone,:correio,:endereco,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome,':telefone'=>$telefone,':correio'=>$correio,':endereco'=>$endereco,':avatar'=>$avatar));
            echo 'add';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM fornecedor where nome LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM fornecedor where nome NOT LIKE '' ORDER BY id_fornecedor desc LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function mudar_logo($id,$nome){
        $sql="UPDATE fornecedor SET avatar=:nome where id_fornecedor=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nome'=>$nome));
    }
    function apagar($id){
        $sql="DELETE FROM fornecedor where id_fornecedor=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
        echo 'apagado';
    }
    else{
        echo 'não apagado';
    }
    }
    function editar($id,$nome,$telefone,$correio,$endereco){
            $sql="SELECT id_fornecedor FROM fornecedor  where id_fornecedor!=:id and nome=:nome ";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':nome'=>$nome));
            $this->objetos=$query->fetchall();
            if(!empty($this->objetos)){
                echo 'noedit';
            }
            else{
                $sql="UPDATE fornecedor  SET nome=:nome,telefone=:telefone, correio=:correio, endereco=:endereco where id_fornecedor=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id,':nome'=>$nome,':telefone'=>$telefone,':correio'=>$correio,':endereco'=>$endereco));
                echo 'edit';
            }
        }
        function preencher_fornecedores(){
            $sql="SELECT * FROM fornecedor  order by nome asc";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
?>