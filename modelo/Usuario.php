<?php
include_once 'Conexao.php';
class Usuario{
    var $objetos;
    public function __construct(){
        $db = new Conexao();
        $this->acceso = $db->pdo;
    }
    function Loguearse($dni,$pass){
        $sql="SELECT * FROM usuario inner join tipo_us on us_tipo=id_tipo_us where dni_us=:dni and senha_us=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni,':pass'=>$pass));
        $this->objetos= $query->fetchAll();
        return $this->objetos; 
    }
    function obter_dados($id){
        $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us and id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos= $query->fetchAll();
        return $this->objetos;   
    }
    function editar($id_usuario,$telefone,$residencia,$correio,$sexo,$adicional){
        $sql="UPDATE usuario SET telefone_us=:telefone,residencia_us=:residencia,correio_us=:correio,sexo_us=:sexo,adicional_us=:adicional where id_usuario=:id";
        $query = $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id_usuario,':telefone'=>$telefone,':residencia'=>$residencia,':correio'=>$correio,':sexo'=>$sexo,':adicional'=>$adicional));
     }
        function mudar_senha($id_usuario,$oldpass,$newpass){
            $sql="SELECT * FROM usuario where id_usuario=:id and senha_us=:oldpass";
            $query = $this->acceso->prepare($sql); 
            $query->execute(array(':id'=>$id_usuario,':oldpass'=>$oldpass));
        $this->objetos = $query->fetchall();
        if(!empty($this->objetos)){$sql="UPDATE usuario SET senha_us=:newpass where id_usuario=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario,':newpass'=>$newpass));
            echo 'update';
        }
        else{
            echo 'noupdate';
        }
    }
    function mudar_foto($id_usuario,$nome){
        $sql="SELECT avatar FROM usuario where id_usuario=:id ";
        $query = $this->acceso->prepare($sql); 
        $query->execute(array(':id'=>$id_usuario));
        $this->objetos = $query->fetchall();

            $sql="UPDATE usuario SET avatar=:nome where id_usuario=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario,':nome'=>$nome));
        return $this->objetos;
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us where nome_us LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us where nome_us NOT LIKE '' ORDER BY id_usuario LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function crear($nome,$apelido,$idade,$dni,$pass,$tipo,$avatar){
        $sql="SELECT id_usuario FROM usuario where dni_us=:dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO usuario(nome_us,apelidos_us,idade,dni_us,senha_us,us_tipo,avatar) VALUE (:nome,:apelido,:idade,:dni,:pass,:tipo,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nome'=>$nome,':apelido'=>$apelido,':idade'=>$idade,':dni'=>$dni,':pass'=>$pass,':tipo'=>$tipo,':avatar'=>$avatar));
            echo 'add';
        }
    }
        function subir($pass,$id_subido,$id_usuario){
            $sql="SELECT id_usuario FROM usuario where id_usuario=:id_usuario and senha_us=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario,':pass'=>$pass));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $tipo=1;
            $sql="UPDATE usuario SET us_tipo=:tipo where id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_subido,':tipo'=>$tipo));
            echo 'subido';
        }
        else{
            echo 'nosubido';
        }
        }
        function descer($pass,$id_descido,$id_usuario){
            $sql="SELECT id_usuario FROM usuario where id_usuario=:id_usuario and senha_us=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario,':pass'=>$pass));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $tipo=2;
            $sql="UPDATE usuario SET us_tipo=:tipo where id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_descido,':tipo'=>$tipo));
            echo 'descido';
        }
        else{
            echo 'nodescido';
        }
    }
        function apagar($pass,$id_apagado,$id_usuario){
            $sql="SELECT id_usuario FROM usuario where id_usuario=:id_usuario and senha_us=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario,':pass'=>$pass));
        $this->objetos=$query->fetchall();
        if(!empty($this->objetos)){
            $sql="DELETE FROM usuario where id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_apagado));
            echo 'apagado';
        }
        else{
            echo 'noapagado';
        }
        }
}
?>