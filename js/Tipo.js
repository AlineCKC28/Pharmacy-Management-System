$(document).ready(function(){
    buscar_tip();
    var funcion;
    var edit=false;
    $('#form-crear-tipo').submit(e=>{
        let nome_tipo= $('#nome-tipo').val();
        let id_editado = $('#id_editar_tip').val();
        if(edit==false){
            funcion='crear';
        }
        else{
            funcion='editar';
        }
        $.post('../controlador/TipoControle.php',{nome_tipo,id_editado,funcion},(response)=>{
            if(response=='add'){
                $('#add-tipo').hide('slow');
                $('#add-tipo').show(1000);
                $('#add-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            if(response=='noadd'){
                $('#noadd-tipo').hide('slow');
                $('#noadd-tipo').show(1000);
                $('#noadd-tipo').hide(2000);
                $('#form-crear-tipo').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-tip').hide('slow');
                $('#edit-tip').show(1000);
                $('#edit-tip').hide(2000);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            edit=false;
        })
        e.preventDefault();
    });
    function buscar_tip(consulta){
        funcion='buscar';
        $.post('../controlador/TipoControle.php',{consulta,funcion},(response)=>{
            const tipos = JSON.parse(response);
            let template='';
            tipos.forEach(tipo => {
                template+=`
                <tr tipId="${tipo.id}" tipnome="${tipo.nome }">
                    <td>  
                        <button class="editar-tip btn btn-success" title="Editar tipo" type="button" data-toggle="modal" data-target="#criartipo">
                            <i class="fas fa-pencil-alt">  </i> 
                        </button>
                        <button class="apagar-tip btn btn-danger" title="Apagar tipo">
                            <i class="fas fa-trash-alt">  </i> 
                        </button>
                   </td>
                    <td>${tipo.nome}</td>
                </tr>
                `;
            });
            $('#tipos').html(template);
        })
    }
    $(document).on('keyup','#buscar-tipo',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_tip(valor);
        }
        else{
            buscar_tip();
        }
    })

    $(document).on('click','.apagar-tip',(e)=>{
        funcion="apagar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');
        const nome = $(elemento).attr('tipnome');
       

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
            icon:'warning',
            showCancelButton: true,
            confirmButtonText: "Sim, apagar isto!",
            cancelButtonText: "Não, cancelar!",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/TipoControle.php',{id,funcion},(response)=>{
                    edit=false;
                   if(response=='apagado'){
                    swalWithBootstrapButtons.fire({
                        title: "Apagado!",
                        text: "O tipo "+nome+" Foi apagado.",
                        icon: "success"
                      });
                      buscar_tip();
                   }
                   else{
                    swalWithBootstrapButtons.fire({
                        title: "Não se pode apagar!",
                        text: "O tipo "+nome+" não foi apagado porque está sendo usado em um produto.",
                        icon: "success"
                      });
                   }
                })
            } else if (
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "O tipo "+nome+"  não foi apagado",
                icon: "error"
              });
            }
          });
    })
    $(document).on('click','.editar-tip',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');
        const nome = $(elemento).attr('tipnome');
        $('#id_editar_tip').val(id);
        $('#nome-tipo').val(nome);
        edit=true;
    })
});