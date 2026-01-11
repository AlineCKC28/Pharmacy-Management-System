<?php
include '../modelo/Fornecedor.php';
$fornecedor = new Fornecedor();
if($_POST['funcion']=='criar'){
    $nome= $_POST['nome'];
    $telefone= $_POST['telefone'];
    $correio= $_POST['correio'];
    $endereco= $_POST['endereco'];
    $avatar= 'forne_default.png';
    $fornecedor->criar($nome,$telefone,$correio,$endereco,$avatar);
}
if($_POST['funcion']=='editar'){
    $id= $_POST['id'];
    $nome= $_POST['nome'];
    $telefone= $_POST['telefone'];
    $correio= $_POST['correio'];
    $endereco= $_POST['endereco'];
    $fornecedor->editar($id,$nome,$telefone,$correio,$endereco);
}
if($_POST['funcion']=='buscar'){
    $fornecedor->buscar();
    $json=array();
    foreach($fornecedor->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_fornecedor,
            'nome'=>$objeto->nome,
            'telefone'=>$objeto->telefone,
            'correio'=>$objeto->correio,
            'endereco'=>$objeto->endereco,
            'avatar'=>'../img/forne/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='mudar_logo'){
    $id=$_POST['id_logo_forne'];
    $avatar=$_POST['avatar'];
    if(($_FILES['foto']['type']=='image/jpeg')||($_FILES['foto']['type']=='image/png')||($_FILES['foto']['type']=='image/gif')){
     $nome=uniqid().'-'.$_FILES['foto']['name'];
    $rota='../img/forne/'.$nome;
    move_uploaded_file($_FILES['foto']['tmp_name'],$rota);
    $fornecedor->mudar_logo($id,$nome);
         if($avatar!='../img/forne/forne_default.png'){
             unlink($avatar);
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
 if($_POST['funcion']=='apagar'){
    $id=$_POST['id'];
    $fornecedor->apagar($id);
 }
 if($_POST['funcion']=='preencher_fornecedores'){
    $fornecedor->preencher_fornecedores();
    $json = array();  
    foreach ($fornecedor->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_fornecedor,
            'nome'=>$objeto->nome
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring; 
}
?>