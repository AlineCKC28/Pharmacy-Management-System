$(document).ready(function(){
    buscar_apre();
    var funcion;
    var edit=false;
    $('#form-crear-apresentacao').submit(e=>{
        let nome_apresentacao= $('#nome-apresentacao').val();
        let id_editado = $('#id_editar_apre').val();
        if(edit==false){
            funcion='crear';
        }
        else{
            funcion='editar';
        }
        $.post('../controlador/ApresentacaoControle.php',{nome_apresentacao,id_editado,funcion},(response)=>{
            if(response=='add'){
                $('#add-apre').hide('slow');
                $('#add-apre').show(1000);
                $('#add-apre').hide(2000);
                $('#form-crear-apresentacao').trigger('reset');
                buscar_apre();
            }
            if(response=='noadd'){
                $('#noadd-apre').hide('slow');
                $('#noadd-apre').show(1000);
                $('#noadd-apre').hide(2000);
                $('#form-crear-apresentacao').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-apre').hide('slow');
                $('#edit-apre').show(1000);
                $('#edit-apre').hide(2000);
                $('#form-crear-apresentacao').trigger('reset');
                buscar_apre();
            }
            edit=false;
        })
        e.preventDefault();
    });
    function buscar_apre(consulta){
        funcion='buscar';
        $.post('../controlador/ApresentacaoControle.php',{consulta,funcion},(response)=>{
            const apresentacoes = JSON.parse(response);
            let template='';
            apresentacoes.forEach(apresentacao => {
                template+=`
                <tr apreId="${apresentacao.id}" aprenome="${apresentacao.nome }">
                    <td>  
                        <button class="editar-apre btn btn-success" title="Editar apresentacao" type="button" data-toggle="modal" data-target="#criarapresentacao">
                            <i class="fas fa-pencil-alt">  </i> 
                        </button>
                        <button class="apagar-apre btn btn-danger" title="Apagar apresentacao">
                            <i class="fas fa-trash-alt">  </i> 
                        </button>
                   </td>
                    <td>${apresentacao.nome}</td>
                </tr>
                `;
            });
            $('#apresentacoes').html(template );
        })
    }
    $(document).on('keyup','#buscar-apresentacao',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_apre(valor);
        }
        else{
            buscar_apre();
        }
    })

    $(document).on('click','.apagar-apre',(e)=>{
        funcion="apagar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('apreId');
        const nome = $(elemento).attr('aprenome');
       

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
                $.post('../controlador/ApresentacaoControle.php',{id,funcion},(response)=>{
                    edit=false;
                   if(response=='apagado'){
                    swalWithBootstrapButtons.fire({
                        title: "Apagado!",
                        text: "O apresentacao "+nome+" Foi apagado.",
                        icon: "success"
                      });
                      buscar_apre();
                   }
                   else{
                    swalWithBootstrapButtons.fire({
                        title: "Não se pode apagar!",
                        text: "O apresentacao "+nome+" não foi apagado porque está sendo usado em um produto.",
                        icon: "success"
                      });
                   }
                })
            } else if (
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "O apresentacao "+nome+"  não foi apagado",
                icon: "error"
              });
            }
          });
    })
    $(document).on('click','.editar-apre',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('apreId');
        const nome = $(elemento).attr('aprenome');
        $('#id_editar_apre').val(id);
        $('#nome-apresentacao').val(nome);
        edit=true;
    })
});