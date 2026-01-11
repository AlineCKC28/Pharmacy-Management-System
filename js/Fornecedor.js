$(document).ready(function(){
  var edit= false;
    var funcion;
    buscar_fornecedor();
    $('#form-criar').submit(e=>{
      let id= $('#id_edit_forne').val();
        let nome= $('#nome').val();
        let telefone= $('#telefone').val();
        let correio= $('#correio').val();
        let endereco= $('#endereco').val();
        if(edit==true){
          funcion="editar"
        }
        else{
          funcion='criar';
        }
       $.post('../controlador/FornecedorControle.php',{id,nome,telefone,correio,endereco,funcion},(response)=>{
        console.log(response);
            if(response=='add'){
                $('#add-forne').hide('slow');
                $('#add-forne').show(1000);
                $('#add-forne').hide(2000);
                $('#form-criar').trigger('reset');
                buscar_fornecedor();
            }
            if(response=='noadd' || response=='noedit'){
                $('#noadd-forne').hide('slow');
                $('#noadd-forne').show(1000);
                $('#noadd-forne').hide(2000);
                $('#form-criar').trigger('reset');
            }
            if(response=='edit'){
              $('#edit-fornece').hide('slow');
              $('#edit-fornece').show(1000);
              $('#edit-fornece').hide(2000);
              $('#form-criar').trigger('reset');
              buscar_fornecedor();
          }
            edit=false;
       });
       e.preventDefault();
    });
    function buscar_fornecedor(consulta){
        funcion='buscar';
        $.post('../controlador/FornecedorControle.php',{consulta,funcion},(response)=>{
            const fornecedores = JSON.parse(response);
            let template='';
            fornecedores.forEach(fornecedor => {
                template+=`
                <div forneId="${fornecedor.id}"forneNome="${fornecedor.nome}"forneTelefone="${fornecedor.telefone}"forneCorreio="${fornecedor.correio}"forneEndereco="${fornecedor.endereco}"forneAvatar="${fornecedor.avatar}"  class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <h1 class="badge badge-success">Fornecedor</h1>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${fornecedor.nome}</b></h2>
                      
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Endereco: ${fornecedor.endereco}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefone: ${fornecedor.telefone}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correio: ${fornecedor.correio}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${fornecedor.avatar}" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <button class="avatar btn btn-sm btn-info" title="Editar logo" type="button" data-toggle="modal" data-target="#mudarlogo">
                      <i class="fas fa-image"></i>
                    </button>
                    <button class="editar btn btn-sm btn-success" title="Editar fornecedor" type="button" data-toggle="modal" data-target="#criar_fornecedor">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button class="apagar btn btn-sm btn-danger" title="Apagar fornecedor">
                  <i class="fas fa-trash-alt"></i>
                </button>
                  </div>
                </div>
              </div>
            </div>
                `;
            });
            $('#fornecedores').html(template);
        });
    }
    $(document).on('keyup','#buscar_fornecedor',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_fornecedor(valor);
        }
        else{
            buscar_fornecedor();
        }
    });
    $(document).on('click','.avatar',(e)=>{
        funcion="mudar_logo";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id= $(elemento).attr('forneId');
        const nome = $(elemento).attr('forneNome');
        const avatar = $(elemento).attr('forneAvatar');
        $('#logoatual').attr('src',avatar);
        $('#nome_logo').html(nome);
        $('#id_logo_forne').val(id);
        $('#funcion').val(funcion);
        $('#avatar').val(avatar);
    });
    $(document).on('click','.editar',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id= $(elemento).attr('forneId');
      const nome = $(elemento).attr('forneNome');
      const endereco = $(elemento).attr('forneEndereco');
      const telefone = $(elemento).attr('forneTelefone');
      const correio = $(elemento).attr('forneCorreio');
      $('#id_edit_forne').val(id);
      $('#nome').val(nome);
      $('#endereco').val(endereco);
      $('#telefone').val(telefone);
      $('#correio').val(correio);
      edit=true;
  });
    $('#form-logo').submit(e=>{
      let formData = new FormData($('#form-logo')[0]);
      $.ajax({
        url:'../controlador/FornecedorControle.php',
        type:'POST',
        data:formData,
        cache:false,
        processData: false,
        contentType:false
      }).done(function(response){
        const json = JSON.parse(response);
        if(json.alert=='edit'){
            $('#logoatual').attr('src',json.rota);
            $('#edit-forne').hide('slow');
            $('#edit-forne').show(1000);
            $('#edit-forne').hide(2000);
            $('#form-logo').trigger('reset');
            buscar_fornecedor();
        }
        else{
          $('#noedit-forne').hide('slow');
          $('#noedit-forne').show(1000);
          $('#noedit-forne').hide(2000);
          $('#form-logo').trigger('reset');
        }
      });
      e.preventDefault();
    });

    $(document).on('click','.apagar',(e)=>{
      funcion="apagar";
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(elemento).attr('forneId');
      const nome = $(elemento).attr('fornenome');
      const avatar = $(elemento).attr('forneAvatar');

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
              $.post('../controlador/FornecedorControle.php',{id,funcion},(response)=>{
                 if(response=='apagado'){
                  swalWithBootstrapButtons.fire({
                      title: "Apagado!",
                      text: "O fornecedor "+nome+" Foi apagado.",
                      icon: "success"
                    });
                    buscar_fornecedor(); 
                 }
                 else{
                  swalWithBootstrapButtons.fire({
                      title: "Não se pode apagar!",
                      text: "O fornecedor "+nome+" não foi apagado porque está sendo usado em um lote.",
                      icon: "error"
                    });
                 }
              })
          } else if (
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire({
              title: "Cancelado",
              text: "O fornecedor "+nome+"  não foi apagado",
              icon: "error"
            });
          }
        });
  })
});