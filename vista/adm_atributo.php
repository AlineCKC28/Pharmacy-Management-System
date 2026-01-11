<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Atributo </title>

  <?php
  include_once 'layouts/nav.php';
  ?>
  <!--modal-->
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
                        <input type="hidden" name="id_logo_lab" id="id_logo_lab">
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
  <!--modal laboratório-->
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
<!--modal tipo-->
<div class="modal fade" id="criartipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar tipo</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
              <div class="alert alert-success text-center" id="add-tipo" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noadd-tipo" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>O Tipo já existe</span>
               </div>
                <div class="alert alert-success text-center" id="edit-tip" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Foi editado corretamente</span>
                </div>
                <form id="form-crear-tipo">
                  <div class="form-group">
                    <label for="nome-tipo">Nome</label>
                    <input id="nome-tipo"type="text" class="form-control" placeholder="Digite o nome" required>
                    <input type="hidden" id="id_editar_tip">
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
<!--modal apresentacão-->
<div class="modal fade" id="criarapresentacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Criar apresentação</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
              <div class="alert alert-success text-center" id="add-apre" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Adicionado corretamente</span>
                </div>
                <div class="alert alert-danger text-center" id="noadd-apre" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>A apresentação já existe</span>
               </div>
                <div class="alert alert-success text-center" id="edit-apre" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Foi editado corretamente</span>
                </div>
                <form id="form-crear-apresentacao">
                  <div class="form-group">
                    <label for="nome-apresentacao">Nome</label>
                    <input id="nome-apresentacao"type="text" class="form-control" placeholder="Digite o nome" required>
                    <input type="hidden" id="id_editar_apre">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestão atributos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gestão atributos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a href="#laboratorio" class="nav-link active" data-toggle="tab">Laboratório</a></li>
                            <li class="nav-item"><a href="#tipo" class="nav-link "data-toggle="tab">Tipo</a></li>
                            <li class="nav-item"><a href="#apresentacao" class="nav-link"data-toggle="tab">Apresentação</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id='laboratorio'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar Laboratório <button type="button" data-toggle="modal" data-target="#criarlaboratorio" class="btn bg-gradient-primary btn-sm m-2">Crear laboratório</button></div>
                                        <div class="input-group">
                                            <input id="buscar-laboratorio"type="text" class="form-control float-left" placeholder="Digite o nome">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                      <table class="table table-hover tex-nowrap">
                                        <thead class="table-success">
                                          <tr>
                                            <th>Acção</th>
                                            <th>Logo</th>
                                            <th>Laboratorio</th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-active" id="laboratorios">

                                        </tboby>
                                      </table>                         
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                            <div class="tab-pane" id='tipo'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar tipo <button type="button" data-toggle="modal" data-target="#criartipo" class="btn bg-gradient-primary btn-sm m-2">Crear tipo</button></div>
                                        <div class="input-group">
                                            <input id="buscar-tipo"type="text" class="form-control float-left" placeholder="Digite o nome">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                      <table class="table table-hover tex-nowrap">
                                        <thead class="table-success">
                                          <tr>
                                            <th>Acção</th>
                                            <th>Tipos</th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-active" id="tipos">

                                        </tboby>
                                      </table>                         
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                            <div class="tab-pane" id='apresentacao'>
                                <div class="card card-success">
                                    <div class="card-header">
                                        <div class="card-title">Buscar apresesentação<button type="button" data-toggle="modal" data-target="#criarapresentacao" class="btn bg-gradient-primary btn-sm m-2">Crear Apresentação</button></div>
                                        <div class="input-group">
                                            <input id="buscar-apresentacao"type="text" class="form-control float-left" placeholder="Digite o nome">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">
                                      <table class="table table-hover tex-nowrap">
                                        <thead class="table-success">
                                          <tr>
                                            <th>Acção</th>
                                            <th>Apresentação</th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-active" id="apresentacoes">

                                        </tboby>
                                      </table>                         
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
    include_once 'layouts/footer.php';
}
else(
    header('Location: ../index.php')
)
?>
<script src="../js/Laboratorio.js"></script>
<script src="../js/Tipo.js"></script>
<script src="../js/Apresentacao.js"></script>
