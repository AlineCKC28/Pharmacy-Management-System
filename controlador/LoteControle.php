<?php
include '../modelo/Lote.php';
$lote = new Lote();
if($_POST['funcion']=='criar'){
    $id_produto = $_POST['id_produto'];
    $fornecedor = $_POST['fornecedor'];
    $stock = $_POST['stock'];
    $vencimento = $_POST['vencimento'];
    $lote->criar($id_produto,$fornecedor,$stock,$vencimento);
}
if($_POST['funcion']=='editar'){
    $id_lote = $_POST['id'];
    $stock = $_POST['stock'];
    $lote->editar($id_lote,$stock);
}
if($_POST['funcion']=='buscar'){
    $lote->buscar();
    $json=array();
    $data_atual = new DateTime();
    foreach ($lote->objetos as $objeto) {
        $vencimento = new DateTime($objeto->vencimento);
        $diferenca = $vencimento->diff($data_atual);
        $mes = $diferenca->m;
        $dia = $diferenca->d;
        $verificado = $diferenca->invert;
        if($verificado==0){
            $estado='danger';
            $mes=$mes*(-1);
            $dia=$dia*(-1);
        }
        else{
            if($mes>3){
                $estado='light';
            }
            if($mes<=3){
                $estado='warning';
            }
        }

        $json[]=array(
        'id'=>$objeto->id_lote,
        'nome'=>$objeto->prod_nom,
        'concentracao'=>$objeto->concentracao,
        'adicional'=>$objeto->adicional,
        'vencimento'=>$objeto->vencimento,
        'fornecedor'=>$objeto->fornecedor,
        'stock'=>$objeto->stock,
        'laboratorio'=>$objeto->lab_nom,
        'tipo'=>$objeto->tip_nom,
        'apresentacao'=>$objeto->apre_nom,
        'avatar'=>'../img/prod/'.$objeto->logo, 
        'mes'=>$mes,
        'dia'=>$dia,
        'estado'=>$estado,
         );
    }
   $jsonstring = json_encode($json);
   echo $jsonstring;
}
if($_POST['funcion']=='apagar'){
    $id=$_POST['id'];
    $lote->apagar($id);
}
?>