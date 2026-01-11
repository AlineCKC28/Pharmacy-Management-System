<?php
session_start();
if($_SESSION['us_tipo']==3||$_SESSION['us_tipo']==1){
    include_once 'layouts/header.php';
?>

  <title>Adm | Gestão Venda </title>

  <?php
  include_once 'layouts/nav.php';
  ?>

  <!--modal criar lote-->
<div class="modal fade" id="vista_venda" tabindex="-1" role="dialog" aria-labelledby="exampleModalL">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Registos de venda</h3>
                <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <div class="form-group">
                    <label for="codigo_venda">Código Venda: </label>
                    <span id="codigo_venda"></span>
                </div>
                <div class="form-group">
                    <label for="data">Data: </label>
                    <span id="data"></span>
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente : </label>
                    <span id="cliente"></span>
                </div>
                <div class="form-group">
                    <label for="dni">DNI Venda: </label>
                    <span id="dni"></span>
                </div>
                <div class="form-group">
                    <label for="vendedor">Vendedor: </label>
                    <span id="vendedor"></span>
                </div>
                <table class="table table-hover text-nowrap">
                  <thead class="table-success">
                    <tr>
                      <th>Quantidade</th>
                      <th>Preço</th>
                      <th>Produto</th>
                      <th>Concetração</th>
                      <th>Adicional</th>
                      <th>Laboratório</th>
                      <th>Apresentação</th>
                      <th>Tipo</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody class="table-warning"id="registos">

                  </tbody>
                </table>
                <div class="float-right input-group-append">
                  <h3 class="m-3">Total: </h3>
                  <h3 class="m-3"id="total"></h3>
                </div>
              </div>
              <div class="card-footer">
              
              <button type="button" data-dismiss="modal"class="btn btn-outline-secondary float-right m-1">Close</button>

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
            <h1>Gestão Vendas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Gestão
              Vendas
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
            <h3 class="card-title">Consultas</h3>
            
          </div>
          <div class="card-body">     
                  <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3 id="venda_dia_vendedor">0</h3>

                        <p>Venda do dia pelo vendedor </p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-user"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3 id="venda_diaria">0</h3>

                        <p>Venda total do dia</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3 id="venda_mensal">0</h3>

                        <p>Venda Mensal</p>
                      </div>
                      <div class="icon">
                        <i class="far fa-calendar-alt"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3 id="venda_anual">0</h3>

                        <p>Venda Anual</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-signal"></i>
                      </div>
                      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
          </div>
          <div class="card-footer">

          </div>
        </div>
      </div>
    </section>
      <section>
    <div class="container-fluid">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Buscar Vendas</h3>
            
          </div>
          <div class="card-body">
                <table id="tabela_venda" class="display table table-hover text-nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>DNI.</th>
                        <th>Total</th>
                        <th>Vendedor</th>
                        <th>Acçcão</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
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
<script src="../js/datatables.js"></script>
<script src="../js/Venda.js"></script>