<?php 
include '../modelo/Laboratorio.php';
$laboratorio=new Laboratorio();
if($_POST['funcion']=='crear'){
    $nome = $_POST['nome_laboratorio'];
    $avatar='lab_default.png';
    $laboratorio->crear($nome,$avatar);
}
if($_POST['funcion']=='editar'){
    $nome = $_POST['nome_laboratorio'];
    $id_editado=$_POST['id_editado'];
    $laboratorio->editar($nome,$id_editado);
}
if($_POST['funcion']=='buscar'){
    $laboratorio->buscar();
    $json=array();
    foreach($laboratorio->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_laboratorio,
            'nome'=>$objeto->nome,
            'avatar'=>'../img/lab/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='mudar_logo'){
   $id=$_POST['id_logo_lab'];
   if(($_FILES['foto']['type']=='image/jpeg')||($_FILES['foto']['type']=='image/png')||($_FILES['foto']['type']=='image/gif')){
    $nome=uniqid().'-'.$_FILES['foto']['name'];
$rota='../img/lab/'.$nome;
move_uploaded_file($_FILES['foto']['tmp_name'],$rota);
$laboratorio->mudar_logo($id,$nome);
    foreach($laboratorio->objetos as $objeto){
        if($objeto->avatar!='lab_default.png'){
            unlink('../img/lab/'.$objeto->avatar);
        }
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
    $laboratorio ->apagar($id);
}
if($_POST['funcion']=='preencher_laboratorios'){
    $laboratorio->preencher_laboratorios();
    $json = array();  
    foreach ($laboratorio->objetos as $objeto){
        $json[]=array(
            'id'=>$objeto->id_laboratorio,
            'nome'=>$objeto->nome
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;
}
?>