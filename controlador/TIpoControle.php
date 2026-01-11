<?php 
include '../modelo/Tipo.php';
$tipo=new Tipo();
if($_POST['funcion']=='crear'){
    $nome = $_POST['nome_tipo'];
    $tipo->crear($nome);
}
if($_POST['funcion']=='editar'){
    $nome = $_POST['nome_tipo'];
    $id_editado=$_POST['id_editado'];
    $tipo->editar($nome,$id_editado);
}
if($_POST['funcion']=='buscar'){
    $tipo->buscar();
    $json=array();
    foreach($tipo->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_tip_prod,
            'nome'=>$objeto->nome,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion']=='apagar'){
    $id=$_POST['id'];
    $tipo->apagar($id);
}
if($_POST['funcion']=='preencher_tipos'){
    $tipo->preencher_tipos();
    $json = array();  
    foreach ($tipo->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_tip_prod,
            'nome'=>$objeto->nome
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
?>