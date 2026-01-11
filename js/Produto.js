 $(document).ready(function(){
    var funcion;
    var edit=false;
    $('.select2').select2();
    preencher_laboratorios();
    preencher_tipos();
    preencher_apresentacoes();
    buscar_produto();
    preencher_fornecedores();
    function preencher_fornecedores() {
      funcion="preencher_fornecedores";
      $.post('../controlador/FornecedorControle.php',{funcion},(response)=>{
          const fornecedores = JSON.parse(response);
          let template='';
          fornecedores.forEach(fornecedor => {
              template+=`
              <option value="${fornecedor.id}">${fornecedor.nome}</option>
              `;
          });
          $('#fornecedor').html(template);
      })
  } 
    function preencher_laboratorios() {
        funcion="preencher_laboratorios";
        $.post('../controlador/LaboratorioControle.php',{funcion},(response)=>{
            const laboratorios = JSON.parse(response);
            let template='';
            laboratorios.forEach(laboratorio => {
                template+=`
                <option value="${laboratorio.id}">${laboratorio.nome}</option>
                `;
            });
            $('#laboratorio').html(template);
        })
    } 
    function preencher_tipos() {
        funcion="preencher_tipos";
        $.post('../controlador/TipoControle.php',{funcion},(response)=>{
            const tipos = JSON.parse(response);
            let template='';
            tipos.forEach(tipo => {
                template+=`
                <option value="${tipo.id}">${tipo.nome}</option>
                `;
            });
            $('#tipo').html(template);
        })
    } 
    function preencher_apresentacoes() {
        funcion="preencher_apresentacoes";
        $.post('../controlador/ApresentacaoControle.php',{funcion},(response)=>{
            const apresentacoes = JSON.parse(response);
            let template='';
            apresentacoes.forEach(apresentacao => {
                template+=`
                <option value="${apresentacao.id}">${apresentacao.nome}</option>
                `;
            });
            $('#apresentacao').html(template);
        })
    }
    $('#form-criar-produto').submit(e=>{
      let id=$('#id_edit_prod').val();
        let nome = $('#nome_produto').val();
        let concentracao = $('#concentracao').val();
        let adicional = $('#adicional').val();
        let preco = $('#preco').val();
        let laboratorio = $('#laboratorio').val();
        let tipo = $('#tipo').val();
        let apresentacao = $('#apresentacao').val();
       if(edit==true){
        funcion="editar";
       }
       else{
        funcion="criar"
       }
        $.post('../controlador/ProdutoControle.php',{funcion,id,nome,concentracao,adicional,preco,laboratorio,tipo,apresentacao},(response)=>{ 
           if(response=='add'){
            $('#add').hide('slow');
            $('#add').show(1000);
            $('#add').hide(2000);
            $('#form-criar-produto').trigger('reset');
            buscar_produto();
           }
           if(response=='edit'){
            $('#edit_prod').hide('slow');
            $('#edit_prod').show(1000);
            $('#edit_prod').hide(2000);
            $('#form-criar-produto').trigger('reset');
            buscar_produto();
           }
           if(response=='noadd'){
            $('#edit_prod').hide('slow');
            $('#edit_prod').show(1000);
            $('#edit_prod').hide(2000);
            $('#form-criar-produto').trigger('reset');
           }
           if(response=='noedit'){
            $('#noadd').hide('slow');
            $('#noadd').show(1000);
            $('#noadd').hide(2000);
            $('#form-criar-produto').trigger('reset');
          }
          edit=false;
        });
        e.preventDefault();
    }); 
    function buscar_produto(consulta){
        funcion="buscar";
        $.post('../controlador/ProdutoControle.php',{consulta,funcion},(response)=>{
            const produtos = JSON.parse(response);
            let template='';
            produtos.forEach(produto =>{
                template+=`
                <div prodId="${produto.id}"prodNome="${produto.nome}"prodPreco="${produto.preco}"prodConcentracao="${produto.concentracao}"prodAdicional="${produto.adicional}"prodLaboratorio="${produto.laboratorio_id}"prodTipo="${produto.tipo_id}"prodApresentacao="${produto.apresentacao_id}"prodAvatar="${produto.avatar}"class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  <i class="fas fa-lg fa-cubes mr-1"></i>${produto.stock}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${produto.nome}</b></h2>
                      <h4 class="lead"><b> <i class="fas fa-lg fa-dollar-sign mr-1"></i>${produto.preco}</b></h4>

                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle"></i></span> Concetração: ${produto.concentracao}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span> Adicional: ${produto.adicional}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span> Laboratório: ${produto.laboratorio}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span> Tipo: ${produto.tipo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span> Apresentação: ${produto.apresentacao}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${produto.avatar}" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="avatar btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#mudarlogo">
                      <i class="fas fa-image"></i>
                    </button>
                    <button class="editar btn btn-sm btn-success"type="button" data-toggle="modal" data-target="#criar_produto">
                      <i class="fas fa-pencil-alt"></i> 
                    </button>
                    <button class="lote btn btn-sm btn-primary"type="button" data-toggle="modal" data-target="#criarlote">
                      <i class="fas fa-plus-square"></i> 
                    </button>
                    <button class="apagar btn btn-sm btn-danger">
                      <i class="fas fa-trash-alt"></i> 
                    </button>
                  </div>
                </div>
              </div>
            </div>
                `;
            });
            $('#produtos').html(template);
        });
    }
    $(document).on('keyup','#buscar-produto',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscar_produto(valor);
        }
        else{
            buscar_produto();
        }
    });
    $(document).on('click','.avatar',(e)=>{
        funcion="mudar_avatar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id= $(elemento).attr('prodId');
        const avatar=$(elemento).attr('prodAvatar');
        const nome = $(elemento).attr('prodNome');
       $('#funcion').val(funcion);
       $('#id_logo_prod').val(id);
       $('#avatar').val(avatar);
       $('#logoatual').attr('src',avatar);
       $('#nome_logo').html(nome);
    });
    $(document).on('click','.lote',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id= $(elemento).attr('prodId');
      const nome=$(elemento).attr('prodNome');
     $('#id_lote_prod').val(id);
     $('#nome_produto_lote').html(nome);
  });
    $('#form-logo').submit(e=>{
      let formData = new FormData($('#form-logo')[0]);
      $.ajax({
        url:'../controlador/ProdutoControle.php',
        type:'POST',
        data:formData,
        cache:false,
        processData: false,
        contentType:false
      }).done(function(response){
        const json = JSON.parse(response);
        if(json.alert=='edit'){
            $('#logoatual').attr('src',json.rota);
            $('#edit').hide('slow');
            $('#edit').show(1000);
            $('#edit').hide(2000);
            $('#form-logo').trigger('reset');
            buscar_produto(); 
        }
        else{
          $('#noedit').hide('slow');
          $('#noedit').show(1000);
          $('#noedit').hide(2000);
          $('#form-logo').trigger('reset');
        }
      });
      e.preventDefault();
    });
    $(document).on('click','.editar',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id= $(elemento).attr('prodId');
      const nome = $(elemento).attr('prodNome');
      const concentracao=$(elemento).attr('prodConcentracao');
      const adicional=$(elemento).attr('prodAdicional');
      const preco=$(elemento).attr('prodPreco');
      const laboratorio=$(elemento).attr('prodLaboratorio');
      const tipo=$(elemento).attr('prodTipo');
      const apresentacao=$(elemento).attr('prodApresentacao');
      console.log(laboratorio+' '+tipo+' '+apresentacao);

      $('#id_edit_prod').val(id);
      $('#nome_produto').val(nome);
      $('#concentracao').val(concentracao);
      $('#adicional').val(adicional);
      $('#preco').val(preco);
      $('#laboratorio').val(laboratorio).trigger('change');
      $('#tipo').val(tipo).trigger('change');
      $('#apresentacao').val(apresentacao).trigger('change');
      edit=true;
      });
      $(document).on('click','.apagar',(e)=>{
        funcion="apagar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('prodId');
        const nome = $(elemento).attr('prodnome');
        const avatar = $(elemento).attr('prodAvatar');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success",
              cancelButton: "btn btn-danger mr-1"
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({
            title: "Deseja eliminar "+nome+"?",
            text: "Não poderás reverter isto!",
            imageUrl:''+avatar+'',
            imageWidth: 100,
            imageHeight: 100,
            showCancelButton: true,
            confirmButtonText: "Sim, apagar isto!",
            cancelButtonText: "Não, cancelar!",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/ProdutoControle.php',{id,funcion},(response)=>{
                    edit==false;
                   if(response=='apagado'){
                    swalWithBootstrapButtons.fire({
                        title: "Apagado!",
                        text: "O produto "+nome+" Foi apagado.",
                        icon: "success"
                      });
                      buscar_produto(); 
                   }
                   else{
                    swalWithBootstrapButtons.fire({
                        title: "Não se pode apagar!",
                        text: "O produto "+nome+" não foi apagado porque está sendo usado em um lote.",
                        icon: "error"
                      });
                   }
                })
            } else if (
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "O produto "+nome+"  não foi apagado",
                icon: "error"
              });
            }
          });
    })
    $('#form-criar-lote').submit(e=>{
      let id_produto=$('#id_lote_prod').val();
      let fornecedor=$('#fornecedor').val();
      let stock=$('#stock').val();
      let vencimento=$('#vencimento').val();
      funcion='criar';
      $.post('../controlador/LoteControle.php',{funcion,vencimento,stock,fornecedor,id_produto},(response)=>{
        $('#add-lote').hide('slow');
          $('#add-lote').show(1000);
          $('#add-lote').hide(2000);
          $('#form-criar-lote').trigger('reset');
          buscar_produto();
      });
      e.preventDefault();
    });

 })