<?php 
include 'Conexao.php';
class Laboratorio{
    var $objetos;
    public function __construct(){
        $db= new Conexao();
        $this->acceso=$db->pdo;
    }
    function crear($nome,$avatar){
        $sql="SELECT id_laboratorio FROM laboratorio where nome=:nome";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nome'=>$nome));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO laboratorio(nome,avatar) values (:nome,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome,':avatar'=>$avatar));
            echo 'add';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM laboratorio where nome LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM laboratorio where nome NOT LIKE '' ORDER BY id_laboratorio LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function mudar_logo($id,$nome){
        $sql="SELECT avatar FROM laboratorio where id_laboratorio=:id";
        $query = $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id));
        $this->objetos = $query->fetchall();

            $sql="UPDATE laboratorio SET avatar=:nome where id_laboratorio=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':nome'=>$nome));
        return $this->objetos;
    }
    function apagar($id){
        $sql="DELETE FROM laboratorio where id_laboratorio=:id";
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
        $sql="UPDATE laboratorio SET nome=:nome where id_laboratorio=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nome'=>$nome));
        echo 'edit';
    }
    function preencher_laboratorios(){
        $sql="SELECT * FROM laboratorio  order by nome asc";
            $query = $this->acceso->prepare($sql); 
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;
    }
}
?>