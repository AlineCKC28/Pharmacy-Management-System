<?php
    include '../modelo/Produto.php';
    $produto=new Produto();
    if($_POST['funcion']=='criar'){
        $nome = $_POST['nome'];
        $concentracao = $_POST['concentracao'];
        $adicional = $_POST['adicional'];
        $preco = $_POST['preco'];
        $laboratorio = $_POST['laboratorio'];
        $tipo = $_POST['tipo'];
        $apresentacao = $_POST['apresentacao'];
        $avatar='prod_default.png';
        $produto->criar($nome,$concentracao,$adicional,$preco,$laboratorio,$tipo,$apresentacao,$avatar);
    }
    if($_POST['funcion']=='editar'){
        $id=$_POST['id'];
        $nome = $_POST['nome'];
        $concentracao = $_POST['concentracao'];
        $adicional = $_POST['adicional'];
        $preco = $_POST['preco'];
        $laboratorio = $_POST['laboratorio'];
        $tipo = $_POST['tipo'];
        $apresentacao = $_POST['apresentacao'];
        $produto->editar($id,$nome,$concentracao,$adicional,$preco,$laboratorio,$tipo,$apresentacao);
    }
    if($_POST['funcion']=='buscar'){
        $produto->buscar();
        $json=array();
        foreach ($produto->objetos as $objeto) {
             $produto->obter_stock($objeto->id_produto);
             foreach($produto->objetos as $obj){
                $total = $obj->total;
             }
            $json[]=array(
            'id'=>$objeto->id_produto,
            'nome'=>$objeto->nome,
            'concentracao'=>$objeto->concentracao,
            'adicional'=>$objeto->adicional,
            'preco'=>$objeto->preco,
            'stock'=>$total,
            'laboratorio'=>$objeto->laboratorio,
            'tipo'=>$objeto->tipo,
            'apresentacao'=>$objeto->apresentacao,
            'avatar'=>'../img/prod/'.$objeto->avatar, 
            
            'laboratorio_id'=>$objeto->prod_lab,
            'tipo_id'=>$objeto->prod_tip_prod,
            'apresentacao_id'=>$objeto->prod_apresent,
            
             );
        }
       $jsonstring = json_encode($json);
       echo $jsonstring;
    } 
    if($_POST['funcion']=='mudar_avatar'){
        $id=$_POST['id_logo_prod'];
        $avatar=$_POST['avatar'];
        if(($_FILES['foto']['type']=='image/jpeg')||($_FILES['foto']['type']=='image/png')||($_FILES['foto']['type']=='image/gif')){
         $nome=uniqid().'-'.$_FILES['foto']['name'];
        $rota='../img/prod/'.$nome;
        move_uploaded_file($_FILES['foto']['tmp_name'],$rota);
        $produto->mudarlogo($id,$nome);
             if($avatar!='../img/prod/prod_default.png'){
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
        $produto->apagar($id);
     }
     if($_POST['funcion']=='buscar_id'){
       $id=$_POST['id_produto'];
       $produto->buscar_id($id);
        $json=array();
        foreach ($produto->objetos as $objeto) {
             $produto->obter_stock($objeto->id_produto);
             foreach($produto->objetos as $obj){
                $total = $obj->total;
             }
            $json[]=array(
            'id'=>$objeto->id_produto,
            'nome'=>$objeto->nome,
            'concentracao'=>$objeto->concentracao,
            'adicional'=>$objeto->adicional,
            'preco'=>$objeto->preco,
            'stock'=>$total,
            'laboratorio'=>$objeto->laboratorio,
            'tipo'=>$objeto->tipo,
            'apresentacao'=>$objeto->apresentacao,
            'avatar'=>'../img/prod/'.$objeto->avatar, 
            
            'laboratorio_id'=>$objeto->prod_lab,
            'tipo_id'=>$objeto->prod_tip_prod,
            'apresentacao_id'=>$objeto->prod_apresent,
            
             );
        }
       $jsonstring = json_encode($json[0]);
       echo $jsonstring;
    } 
    if($_POST['funcion']=='verificar_stock'){
       $erro=0;
       $produtos=json_decode($_POST['produtos']);
       foreach ($produtos as $objeto) {
        $produto->obter_stock($objeto->id);
        foreach ($produto->objetos as $obj) {
          $total=$obj->total;
        }
        if($total>=$objeto->quantidade && $objeto->quantidade>0){
            $erro=$erro+0;
        }
        else{
            $erro=$erro+1;
        }
       }
       echo $erro;
    }
?>