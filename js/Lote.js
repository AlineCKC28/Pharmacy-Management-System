$(document).ready(function(){
    var funcion;

    buscar_lote();
    
    function buscar_lote(consulta){
        funcion="buscar";
        $.post('../controlador/LoteControle.php',{consulta,funcion},(response)=>{
            const lotes = JSON.parse(response);
            let template='';
            lotes.forEach(lote =>{
                template+=`
                <div loteId="${lote.id}"loteStock="${lote.stock}"class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">`;
                if(lote.estado=='light'){
                template+=`
              <div class="card bg-light d-flex flex-fill">`;
            }
            if(lote.estado=='danger'){
                template+=`
              <div class="card bg-danger d-flex flex-fill">`;
            }
            if(lote.estado=='warning'){
                template+=`
              <div class="card bg-warning d-flex flex-fill">`;
            }
              template+=` <div class="card-header border-bottom-0">
              <h6> Codigo ${lote.id}</h6>
                  <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>${lote.nome}</b></h2>

                      <ul class="ml-4 mb-0 fa-ul">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mortar-pestle"></i></span> Concetração: ${lote.concentracao}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span> Adicional: ${lote.adicional}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span> Laboratório: ${lote.laboratorio}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span> Tipo: ${lote.tipo}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span> Apresentação: ${lote.apresentacao}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span> Vencimento: ${lote.vencimento}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span> Fornecedor: ${lote.fornecedor}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span> Mes: ${lote.mes}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span> Dia: ${lote.dia}</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${lote.avatar}" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    
                    <button class="editar btn btn-sm btn-success"type="button" data-toggle="modal" data-target="#editarlote">
                      <i class="fas fa-pencil-alt"></i> 
                    </button>
                    
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
            $('#lotes').html(template);
        });
    }
    $(document).on('keyup','#buscar-lote',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscar_lote(valor);
        }
        else{
            buscar_lote();
        }
    });
    $(document).on('click','.editar',(e)=>{
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(elemento).attr('loteId');
      const stock = $(elemento).attr('loteStock');
    
      $('#id_lote_prod').val(id);
      $('#stock').val(stock);
      $('#codigo_lote').html(id);
      
      });
      $('#form-editar-lote').submit(e=>{
        let id = $('#id_lote_prod').val();
        let stock = $('#stock').val();
        funcion="editar";
        $.post('../controlador/LoteControle.php',{id,stock,funcion},(response)=>{
          if(response=='edit'){
            $('#edit-lote').hide('slow');
            $('#edit-lote').show(1000);
            $('#edit-lote').hide(2000);
            $('#form-editar-lote').trigger('reset');
           }
           buscar_lote();
        })
        e.preventDefault();
     })
     $(document).on('click','.apagar',(e)=>{
      funcion="apagar";
      const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(elemento).attr('loteId');
      

      const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger mr-1"
          },
          buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
          title: "Deseja eliminar lote "+id+"?",
          text: "Não poderás reverter isto!",
         icon:"Warning",
          showCancelButton: true,
          confirmButtonText: "Sim, apagar isto!",
          cancelButtonText: "Não, cancelar!",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
              $.post('../controlador/LoteControle.php',{id,funcion},(response)=>{
                 if(response=='apagado'){
                  swalWithBootstrapButtons.fire({
                      title: "Apagado!",
                      text: "O lote "+id+" Foi apagado.",
                      icon: "success"
                    });
                    buscar_lote(); 
                 }
                 else{
                  swalWithBootstrapButtons.fire({
                      title: "Não se pode apagar!",
                      text: "O lote "+id+" não foi apagado porque está sendo usado.",
                      icon: "error"
                    });
                 }
              })
          } else if (
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire({
              title: "Cancelado",
              text: "O lote "+id+"  não foi apagado",
              icon: "error"
            });
          }
        });
  })
 })