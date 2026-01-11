<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Editar Dados </title>

  <?php
  include_once 'layouts/nav.php';
  ?>
 <!--modal Mudar lodo do fornecedor-->
 <div class="modal fade" id="mudarlogo" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
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
                <div class="alert alert-success text-center" id="edit-forne" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Logo editado</span>
                </div>
                <div class="alert alert-danger text-center" id="noedit-forne" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>Formato não suportado</span>
               </div>
                <form id="form-logo" enctype="multipart/form-data">
                    <div class="input-group mb-3 ml-5 mt-2">
                        <input type="file" name="foto"class="input-group">
                        <input type="hidden" name="funcion" id="funcion">
                        <input type="hidden" name="id_logo_forne" id="id_logo_forne">
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
<!--modal Criar fornecedor-->
<div class="modal fade" id="criar_fornecedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar fornecedor</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <div class="alert alert-success text-center" id="add-forne" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noadd-forne" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>O fornecedor já existe</span>
               </div>
               <div class="alert alert-success text-center" id="edit-fornece" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Modificado corretamente</span>
                </div>
                <form id="form-criar">
                  <div class="form-group">
                    <label for="nome">Nomes</label>
                    <input id="nome"type="text" class="form-control" placeholder="Digite o nome" required>
                  </div>
                  <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input id="telefone"type="number" class="form-control" placeholder="Digite o número de telefone" required>
                  </div>
                  <div class="form-group">
                    <label for="correio">Correio </label>
                    <input id="correio"type="email" class="form-control" placeholder="Digite o correio" required>
                  </div>
                  <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input id="endereco"type="text" class="form-control" placeholder="Digite a Endereço" required>
                  </div>
                 <input type="hidden" id="id_edit_forne">
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

  <!-- Modal Criar fornecedor -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestão fornecedor <button type="button" data-toggle="modal" data-target="#criar_fornecedor"class="btn bg-gradient-primary ml-2">Criar fornecedor</button></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestão
                fornecedor
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div class="container-fluid">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Buscar fornecedor</h3>
            <div class="input-group">
              <input type="text" id="buscar_fornecedor"class="form-control float-left" placeholder="Digite o nome do fornecedor">
              <div class="input-group-append">
                <button class="btn btn-default"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
          <div class="card-body">
          <div id="fornecedores" class="row d-flex align-items-stretch">
            
          </div>
          </div>
          <div class="card-footer">

          </div>
        </div>
      </div>
    <section>
        
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
<script src="../js/Fornecedor.js"></script>