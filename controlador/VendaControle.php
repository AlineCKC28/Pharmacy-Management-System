<?php
include '../modelo/Venda.php';
$venda = new Venda();
session_start(); 
$id_usuario= $_SESSION['usuario']; 
if($_POST['funcion']=='listar'){
    $venda->buscar();
    $json=array();
    foreach ($venda->objetos as $objeto) {
       $json['data'][]=$objeto;
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
if($_POST['funcion']=='mostrar_consultas'){
    $venda->venda_dia_vendedor($id_usuario);
    foreach ($venda->objetos as $objeto) {
        $venda_dia_vendedor=$objeto->venda_dia_vendedor;
    }
    $venda->venda_diaria();
    foreach ($venda->objetos as $objeto) {
        $venda_diaria=$objeto->venda_diaria;
    }
    $venda->venda_mensal();
    foreach ($venda->objetos as $objeto) {
        $venda_mensal=$objeto->venda_mensal;
    }
    $venda->venda_anual();
    $json=array();
    foreach ($venda->objetos as $objeto) {
       $json[]=array(
        'venda_dia_vendedor'=>$venda_dia_vendedor,
        'venda_diaria'=>$venda_diaria,
        'venda_mensal'=>$venda_mensal,
        'venda_anual'=>$objeto->venda_anual
       );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
?>