<?php
include '../modelo/Venda.php';
include_once '../modelo/Conexao.php';
$venda= new Venda();
session_start();
$vendedor = $_SESSION['usuario'];
if($_POST['funcion']=='registar_compra'){
    $total=$_POST['total'];
    $nome=$_POST['nome'];
    $dni=$_POST['dni'];
    $produtos=json_decode($_POST['json']);
    date_default_timezone_set('Africa/Luanda');
    $datta= date('Y-m-d H:i:s');
    $venda-> Criar($nome,$dni,$total,$datta,$vendedor);
    $venda->ultima_venda();
    foreach ($venda->objetos as $objeto) {
        $id_venda = $objeto->ultima_venda;
        echo $id_venda;
    }
    try {
       $db= new Conexao();
       $conexion = $db->pdo;
       $conexion->beginTransaction();
       foreach ($produtos as $prod) {
        $quantidade= $prod->quantidade;
        while($quantidade!=0){
                $sql="SELECT * FROM lote where vencimento = (SELECT MIN(vencimento) FROM lote where lote_id_prod=:id) and lote_id_prod=:id";
            $query = $conexion->prepare($sql);
            $query->execute(array(':id'=>$prod->id));
            $lote=$query->fetchall();
            foreach ($lote as $lote) {
                if($quantidade<$lote->stock){
                    $sql="INSERT INTO  detalhe_venda(det_quantidade,det_vencimento,id__det_lote,id__det_prod,lote_id_forne,id_det_venda) values ('$quantidade','$lote->vencimento','$lote->id_lote','$prod->id','$lote->lote_id_prod','$id_venda')";
                    $conexion->exec($sql);
                    $conexion->exec("UPDATE lote SET stock= stock- '$quantidade' where id_lote='$lote->id_lote'");
                    $quantidade=0;
                }
                if($quantidade==$lote->stock){
                    $sql="INSERT INTO  detalhe_venda(det_quantidade,det_vencimento,id__det_lote,id__det_prod,lote_id_forne,id_det_venda) values ('$quantidade','$lote->vencimento','$lote->id_lote','$prod->id','$lote->lote_id_prod','$id_venda')";
                    $conexion->exec($sql);
                    $conexion->exec("DELETE FROM lote  where id_lote='$lote->id_lote'");
                    $quantidade=0;
                }
                if($quantidade>$lote->stock){
                    $sql="INSERT INTO  detalhe_venda(det_quantidade,det_vencimento,id__det_lote,id__det_prod,lote_id_forne,id_det_venda) values ('$lote->stock','$lote->vencimento','$lote->id_lote','$prod->id','$lote->lote_id_prod','$id_venda')";
                    $conexion->exec($sql);
                    $conexion->exec("DELETE FROM lote  where id_lote='$lote->id_lote'");
                    $quantidade=$quantidade-$lote->stock;
                }
            }
        }
        $subtotal = $prod->quantidade*$prod->preco;
        $conexion->exec("INSERT INTO venda_produto(quantidade,subtotal,produto_id_produto,venda_id_venda) values('$prod->quantidade','$subtotal','$prod->id','$id_venda')");
       }
       $conexion->commit();

    } catch (Exception $erro) {
       
        $conexion->rollBack();
        $venda->apagar($id_venda);
        echo $erro->getMessage();
    }
}
?>