<?php
    include_once '../modelo/Usuario.php';
    $usuario = new Usuario();
    session_start();
    $id_usuario= $_SESSION['usuario'];
    if($_POST['funcion']=='buscar_usuario'){
        $json=array();
        $data_actual = new DateTime();
        $usuario->obter_dados($_POST['dado']);
        foreach ($usuario->objetos as $objeto) {
            $nascimento = new DateTime($objeto->idade);
            $idade = $nascimento->diff($data_actual);
            $idade_years = $idade->y;
            $json[]=array(
                'nome'=>$objeto->nome_us,
                'apelidos'=>$objeto->apelidos_us,
                'idade'=>$idade_years,
                'dni'=>$objeto->dni_us,
                'tipo'=>$objeto->nome_tipo,
                'telefone'=>$objeto->telefone_us,
                'residencia'=>$objeto->residencia_us,
                'correio'=>$objeto->correio_us,
                'sexo'=>$objeto->sexo_us,
                'adicional'=>$objeto->adicional_us,
                'avatar'=>'../img/'.$objeto->avatar

            );
        }
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
    if($_POST['funcion']=='capturar_dados'){
        $json=array();
        $id_usuario=$_POST['id_usuario'];
        $usuario->obter_dados($id_usuario);
        foreach ($usuario->objetos as $objeto) {
            $json[]=array(
                'telefone'=>$objeto->telefone_us,
                'residencia'=>$objeto->residencia_us,
                'correio'=>$objeto->correio_us,
                'sexo'=>$objeto->sexo_us,
                'adicional'=>$objeto->adicional_us 
            );
        }
        $jsonstring = json_encode($json[0]);
        echo $jsonstring;
    }
    if($_POST['funcion']=='editar_usuario'){
        $id_usuario=$_POST['id_usuario'];
        $telefone=$_POST['telefone'];
        $residencia=$_POST['residencia'];
        $correio=$_POST['correio'];
        $sexo=$_POST['sexo'];
        $adicional=$_POST['adicional'];
        $usuario->editar($id_usuario,$telefone,$residencia,$correio,$sexo,$adicional);
        echo 'editado';
    }

    if($_POST['funcion']=='mudar_senha'){
        $id_usuario=$_POST['id_usuario'];
        $oldpass=$_POST['oldpass'];
        $newpass=$_POST['newpass'];
        $usuario->mudar_senha($id_usuario,$oldpass,$newpass);
    }

    if($_POST['funcion']=='mudar_foto'){
        if(($_FILES['foto']['type']=='image/jpeg')||($_FILES['foto']['type']=='image/png')||($_FILES['foto']['type']=='image/gif')){
            $nome=uniqid().'-'.$_FILES['foto']['name'];
       $rota='../img/'.$nome;
        move_uploaded_file($_FILES['foto']['tmp_name'],$rota);
        $usuario->mudar_foto($id_usuario,$nome);
            foreach($usuario->objetos as $objeto){
                unlink('../img/'.$objeto->avatar);
            }
            $json= array();
            $json[]=array(
                'rota'=>$rota,
                'alert'=>'edit'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
        else{
            $json= array();
            $json[]=array(
                'alert'=>'noedit'
            );
            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    if($_POST['funcion']=='buscar_usuarios_adm'){
        $json=array();
        $data_actual = new DateTime();
        $usuario->buscar();
        foreach ($usuario->objetos as $objeto) {
            $nascimento = new DateTime($objeto->idade);
            $idade = $nascimento->diff($data_actual);
            $idade_years = $idade->y;
            $json[]=array(
                'id'=>$objeto->id_usuario,
                'nome'=>$objeto->nome_us,
                'apelidos'=>$objeto->apelidos_us,
                'idade'=>$idade_years,
                'dni'=>$objeto->dni_us,
                'tipo'=>$objeto->nome_tipo,
                'telefone'=>$objeto->telefone_us,
                'residencia'=>$objeto->residencia_us,
                'correio'=>$objeto->correio_us,
                'sexo'=>$objeto->sexo_us,
                'adicional'=>$objeto->adicional_us,
                'avatar'=>'../img/'.$objeto->avatar,
                'tipo_usuario'=>$objeto->us_tipo     
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    if($_POST['funcion']=='crear_usuario'){
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $idade = $_POST['idade'];
        $dni = $_POST['dni'];
        $pass = $_POST['pass'];
        $tipo=2;
        $avatar='default.jpg';
        $usuario->crear($nome,$apelido,$idade,$dni,$pass,$tipo,$avatar);
    }
    if($_POST['funcion']=='subir'){
        $pass=$_POST['pass'];
        $id_subido=$_POST['id_usuario'];
        $usuario->subir($pass,$id_subido,$id_usuario);
    }
    if($_POST['funcion']=='descer'){
        $pass=$_POST['pass'];
        $id_descido=$_POST['id_usuario'];
        $usuario->descer($pass,$id_descido,$id_usuario);
    }
    if($_POST['funcion']=='apagar-usuario'){
        $pass=$_POST['pass'];
        $id_apagado=$_POST['id_usuario'];
        $usuario->apagar($pass,$id_apagado,$id_usuario);
    }
?>