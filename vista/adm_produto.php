<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Editar Dados </title>

  <?php
  include_once 'layouts/nav.php';
  ?>
  <!--modal criar lote-->
<div class="modal fade" id="criarlote" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar lote</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <div class="alert alert-success text-center" id="add-lote" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <form id="form-criar-lote">
                <div class="form-group">
                    <label for="nome_produto_lote">Produto: </label>
                    <label id="nome_produto_lote">Nome do produto</label>
                  </div>
                <div class="form-group">
                    <label for="fornecedor">Fornecedores</label>
                    <select name="fornecedor" id="fornecedor" class="form-control select2"style="width:100%;"></select>
                  </div>
                  <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input id="stock"type="number" class="form-control" placeholder="Digite o stock">
                  </div>
                  <div class="form-group">
                    <label for="vencimento">Vencimento</label>
                    <input id="vencimento"type="date" class="form-control" placeholder="Digita data de vencimento">
                  </div>
                  <input type="hidden" id="id_lote_prod">
              </div>
              <div class="card-footer">
              <button type="submit"class="btn bg-gradient-primary float-right m-1">Guardar
              </button>
              <button type="button" data-dismiss="modal"class="btn btn-outline-secondary float-right m-1">Close</button>
              </form>
              </div>
            </div>
        </div>
    </div>
</div>
  <!--modal mudar loga de laboratório-->
<div class="modal fade" id="mudarlogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">z
                <h5 class="modal-title" id="exampleModalLabel">Mudar logo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="logoatual"src="../img/avatar.png" class="profile-user-img img fluid img-circle">
                </div>
                <div class="text-center">
                    <b id="nome_logo">
                    </b>
                </div>  
                <div class="alert alert-success text-center" id="edit" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Logo editado</span>
                </div>
                <div class="alert alert-danger text-center" id="noedit" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>Formato não suportado</span>
               </div>
                <form id="form-logo" enctype="multipart/form-data">
                    <div class="input-group mb-3 ml-5 mt-2">
                        <input type="file" name="foto"class="input-group">
                        <input type="hidden" name="funcion" id="funcion">
                        <input type="hidden" name="id_logo_prod" id="id_logo_prod">
                        <input type="hidden" name="avatar" id="avatar">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Feixar</button>
                <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
  <!--modal criar laboratório-->
<div class="modal fade" id="criarlaboratorio" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar laboratório</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <div class="alert alert-success text-center" id="add-laboratorio" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noadd-laboratorio" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>Laboratorio já existe</span>
               </div>
                <div class="alert alert-success text-center" id="edit-lab" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Foi editado corretamente</span>
                </div>
                <form id="form-crear-laboratorio">
                  <div class="form-group">
                    <label for="nome-laboratorio">Nome</label>
                    <input id="nome-laboratorio"type="text" class="form-control" placeholder="Digite o nome" required>
                    <input type="hidden" id="id_editar_lab">
                  </div>
              </div>
              <div class="card-footer">
              <button type="submit"class="btn bg-gradient-primary float-right m-1">Guardar
              </button>
              <button type="button" data-dismiss="modal"class="btn btn-outline-secondary float-right m-1">Close</button>
              </form>
              </div>
            </div>
        </div>
    </div>
</div>
<!--modal criar produto-->
<div class="modal fade" id="criar_produto" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar produto</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <div class="alert alert-success text-center" id="add" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noadd" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>Produto já existe em outro usuário</span>
               </div>
               <div class="alert alert-success text-center" id="edit_prod" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <form id="form-criar-produto">
                  <div class="form-group">
                    <label for="nome_produto">Nome</label>
                    <input id="nome_produto"type="text" class="form-control" placeholder="Digite o nome" required>
                  </div>
                  <div class="form-group">
                    <label for="concentracao">Concentração</label>
                    <input id="concentracao"type="text" class="form-control" placeholder="Digite a concentração">
                  </div>
                  <div class="form-group">
                    <label for="adicional">Adicional</label>
                    <input id="adicional"type="text" class="form-control" placeholder="Digite informação adicional">
                  </div>
                  <div class="form-group">
                    <label for="preco">Preço</label>
                    <input id="preco"type="number" step="any" class="form-control" value='1' placeholder="Digite o preco" required>
                  </div>
                  <div class="form-group">
                    <label for="laboratorio">Laboratório</label>
                    <select name="laboratorio" id="laboratorio" class="form-control select2"style="width:100%;"></select>
                  </div>
                  <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control select2"style="width:100%;"></select>
                  </div>
                  <div class="form-group">
                    <label for="apresentacao">Apresentação</label>
                    <select name="apresentacao" id="apresentacao" class="form-control select2"style="width:100%;"></select>
                  </div>
                  <input type="hidden" id="id_edit_prod">
              </div>
              <div class="card-footer">
              <button type="submit"class="btn bg-gradient-primary float-right m-1">Guardar
              </button>
              <button type="button" data-dismiss="modal"class="btn btn-outline-secondary float-right m-1">Close</button>
              </form>
              </div>
            </div>
        </div>
    </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestão produto <button id="button-crear"type="button" data-toggle="modal" data-target="#criar_produto"class="btn bg-gradient-primary ml-2">Criar produto</button></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestão
              produto
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid buscar produto -->
    </section>
    <section>
    <div class="container-fluid">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Buscar produto</h3>
            <div class="input-group">
              <input type="text" id="buscar-produto"class="form-control float-left" placeholder="Digite o nome do produto">
              <div class="input-group-append">
                <button class="btn btn-default"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
          <div class="card-body">
          <div id="produtos" class="row d-flex align-items-stretch">
            
          </div>
          </div>
          <div class="card-footer">

          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php
    include_once 'layouts/footer.php';
}
else(
    header('Location: ../index.php')
)
?>
<script src="../js/Produto.js"></script>