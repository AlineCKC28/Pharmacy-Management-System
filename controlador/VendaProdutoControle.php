<?php
include_once '../modelo/VendaProduto.php';
$venda_produto = new VendaProduto();
if($_POST['funcion']=='ver'){
    $id=$_POST['id'];
    $venda_produto->ver($id);
    $json=array();
    foreach ($venda_produto->objetos as $objeto) {
       $json[]=$objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
?>