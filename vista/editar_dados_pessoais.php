<?php
session_start();
if($_SESSION['us_tipo']==1||$_SESSION['us_tipo']==3){
    include_once 'layouts/header.php';
?>

  <title>Adm | Editar Dados </title>

  <?php
  include_once 'layouts/nav.php';
  ?>
  <!--modal-->
<div class="modal fade" id="mudar_senha" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mudar password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img  id="avatar3"src="../img/avatar.png" class="profile-user-img img fluid img-circle">
                </div>
                <div class="text-center">
                    <b>
                    <?php
                    echo $_SESSION['nome_us'];
                    ?>
                    </b>
                </div>  
                <div class="alert alert-success text-center" id="update" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Password modificada corretamenta</span>
                </div>
                <div class="alert alert-danger text-center" id="noupdate" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>A password não está correta</span>
               </div>
                <form id="form-pass">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i
                            class="fas fa-unlock-alt"></i></span>
                        </div>
                        <input id="oldpass" type="password" class="form-control" placeholder="Digite a password actual">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i
                            class="fas fa-lock"></i></span>
                        </div>
                        <input id="newpass" type="text" class="form-control" placeholder="Digite a password nova">
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

<!--modal-->
<div class="modal fade" id="mudar_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mudar avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="avatar1"src="../img/avatar.png" class="profile-user-img img fluid img-circle">
                </div>
                <div class="text-center">
                    <b>
                    <?php
                    echo $_SESSION['nome_us'];
                    ?>
                    </b>
                </div>  
                <div class="alert alert-success text-center" id="edit" style='display:none;'>
                     <span><i class="fas fa-check m-1"></i>Mudou o avatar</span>
                </div>
                <div class="alert alert-danger text-center" id="noedit" style='display:none;'>
                     <span><i class="fas fa-times m-1"></i>Formato não suportado</span>
               </div>
                <form id="form-foto" enctype="multipart/form-data">
                    <div class="input-group mb-3 ml-5 mt-2">
                        <input type="file" name="foto"class="input-group">
                        <input type="hidden" name="funcion" value="mudar_foto">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dados pessoais</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Dados pessoais</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!--Dentro desta section está todas as configurações feitas no conteúdo. do dados pessoais como como as a imagem do avatar que está de baixo do titulo dados pessois-->
    <section>
        <div class="content"> 
            <div class="container-fluid">
                <div class="row">
                    <!-- Esta DIV terá uma Coluna de tamanho médio e que vai ocupar três colunas onde estarão todos os dados pessoais como como as a imagem do avatar que está de baixo do titulo dados pessois -->
                    <div class="col-md-3">
                        <div class=" card card-success card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img id='avatar2'src="../img/avatar.png" class="profile-user-img img img-fluid img-circle">
                                </div>
                                <div class="text-center mt-1">
                                    <button  type="button" data-toggle="modal" data-target="#mudar_foto" class="btn btn-primary btn-sm "> Mudar avatar</button>
                                </div>
                                <input id="id_usuario"type="hidden" value="<?php echo $_SESSION['usuario']?>">
                                <h3 id="nome_us"class="profile-username text-center text-success">Nome</h3>
                                <p id="apelidos_us"class="text-muted text-center">Apelidos</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                      <b style="color:#0B7300">Idade</b>
                                        <a id="idade"class="float-right">12</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color:#0B7300">DNI</b>
                                        <a id="dni_us"class="float-right">12</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color:#0B7300">Tipo Usuário</b>
                                        <span id="us_tipo"class=" float-right">Administrador</span>
                                    </li>
                                    <button data-toggle="modal" data-target="#mudar_senha" type="button" class="btn btn-block btn-outline-warning btn-sm">Mudar password</button>
                                </ul>
                            </div>
                        </div>
                        <!-- Aqui vai estar outro card o primeiro card foi ond colocai todas as informaçõe sobre os dados do usúairio -->
                        <div class="cader card-success">
                            <div class="card-header">
                                <h3 class="card-title">Sobre mim</h3>
                            </div>
                            <div class="card-body">
                                <strong style="color:#0B7300"><i class="fas fa-phone mr-1"></i>Telefone</strong>
                                <p id='telefone_us'class="text-muted">948 485 489</p>
                                <strong style="color:#0B7300"><i class="fas fa-map-marker-alt mr-1"></i>Residência</strong>
                                <p id="residencia_us"class="text-muted">948 485 489</p>
                                <strong style="color:#0B7300"><i class="fas fa-at mr-1"></i>Correio</strong>
                                <p id="correio_us"class="text-muted">948 485 489</p>
                                <strong style="color:#0B7300"><i class="fas fa-smile-wink mr-1"></i>Sexo</strong>
                                <p id="sexo_us"class="text-muted">948 485 489</p>
                                <strong style="color:#0B7300"><i class="fas fa-pencil-alt mr-1"></i>informação adicional</strong>
                                <p id="adicional_us"class="text-muted">948 485 489</p>
                                <button class="edit btn btn-block bg-gradient-danger">Editar</button>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">Click no botão se desejar editar</p>
                            </div>
                        </div>
                    </div>
                    <!--Aqui termina -->
                    <!--Aqui Começa uma coluna média que vai ocupar 9 colunas -->
                    <div class="col-md-9">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Editar dados pessoais</h3> 
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success text-center" id="editado" style='display:none;'>
                                    <span><i class="fas fa-check m-1"></i>Editado</span>
                                </div>
                                <div class="alert alert-danger text-center" id="naoeditado" style='display:none;'>
                                    <span><i class="fas fa-times m-1"></i>Edição desabilitada</span>
                                </div>
                                <form id='form-usuario'class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="telefone" class="col-sm-2 col-from-label">Telefone</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="telefone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="residencia" class="col-sm-2 col-from-label">Residência</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="residencia" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correio" class="col-sm-2 col-from-label">Correio</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="correio" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sexo" class="col-sm-2 col-from-label">Sexo</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="sexo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adicional" class="col-sm-2 col-from-label">informação adicional</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="adicional" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10 float-right">
                                            <button class="btn btn-block btn-outline-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card body"></div>
                            <div class="card-footer">
                                <p class="text-muted">Cuidado ao colocar dados errados</p>
                            </div>
                        </div>
                    </div>
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
<script src="../js/Usuario.js"></script>