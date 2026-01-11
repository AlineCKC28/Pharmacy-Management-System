<?php 
include '../modelo/Apresentacao.php';
$apresentacao=new Apresentacao();
if($_POST['funcion']=='crear'){
    $nome = $_POST['nome_apresentacao'];
    $apresentacao->crear($nome);
}
if($_POST['funcion']=='editar'){
    $nome = $_POST['nome_apresentacao'];
    $id_editado=$_POST['id_editado'];
    $apresentacao->editar($nome,$id_editado);
}
if($_POST['funcion']=='buscar'){
    $apresentacao->buscar();
    $json=array();
    foreach($apresentacao->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_apresentacao,
            'nome'=>$objeto->nome,
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if($_POST['funcion']=='apagar'){
    $id=$_POST['id'];
    $apresentacao->apagar($id);
}
if($_POST['funcion']=='preencher_apresentacoes'){
    $apresentacao->preencher_apresentacoes();
    $json = array();  
    foreach ($apresentacao->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_apresentacao,
            'nome'=>$objeto->nome
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
?>