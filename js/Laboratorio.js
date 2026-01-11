$(document).ready(function(){
    buscar_lab();
    var funcion;
    var edit=false;
    $('#form-crear-laboratorio').submit(e=>{
        let nome_laboratorio = $('#nome-laboratorio').val();
        let id_editado = $('#id_editar_lab').val();
        if(edit==false){
            funcion='crear';
        }
        else{
            funcion='editar';
        }
        $.post('../controlador/LaboratorioControle.php',{nome_laboratorio,id_editado,funcion},(response)=>{
            if(response=='add'){
                $('#add-laboratorio').hide('slow');
                $('#add-laboratorio').show(1000);
                $('#add-laboratorio').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_lab();
            }
            if(response=='noadd'){
                $('#noadd-laboratorio').hide('slow');
                $('#noadd-laboratorio').show(1000);
                $('#noadd-laboratorio').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-lab').hide('slow');
                $('#edit-lab').show(1000);
                $('#edit-lab').hide(2000);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_lab();
            }
            edit=false;
        })
        e.preventDefault();
    });
    function buscar_lab(consulta){
        funcion='buscar';
        $.post('../controlador/LaboratorioControle.php',{consulta,funcion},(response)=>{
            const laboratorios = JSON.parse(response);
            let template='';
            laboratorios.forEach(laboratorio => {
                template+=`
                <tr labId="${laboratorio.id}" labnome="${laboratorio.nome }" labavatar="${laboratorio.avatar}" >
                    <td>  
                        <button class="avatar btn btn-info" title="Mudar logo do laboratório" type="button" data-toggle="modal" data-target="#mudarlogo">
                            <i class="far fa-image">  </i> 
                        </button>
                        <button class="editar btn btn-success" title="Editar laboratório" type="button" data-toggle="modal" data-target="#criarlaboratorio">
                            <i class="fas fa-pencil-alt">  </i> 
                        </button>
                        <button class="apagar btn btn-danger" title="Apagar laboratório">
                            <i class="fas fa-trash-alt">  </i> 
                        </button>
                   </td>
                   <td>
                     <img src="${laboratorio.avatar}" class="img-fluid rounded" width="70" heigth="70">
                    </td>
                    <td>${laboratorio.nome}</td>
                </tr>
                `;
            });
            $('#laboratorios').html(template);
        })
    }
    $(document).on('keyup','#buscar-laboratorio',function(){
        let valor = $(this).val();
        if(valor!=''){
            buscar_lab(valor);
        }
        else{
            buscar_lab();
        }
    })
    $(document).on('click','.avatar',(e)=>{
        funcion="mudar_logo";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nome = $(elemento).attr('labnome');
        const avatar = $(elemento).attr('labavatar');
        $('#logoatual').attr('src',avatar);
        $('#nome_logo').html(nome);
        $('#funcion').val(funcion);
        $('#id_logo_lab').val(id);
    })
    $('#form-logo').submit(e=>{
        let formData = new FormData($('#form-logo')[0]);
        $.ajax({
            url:'../controlador/LaboratorioControle.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
           const json = JSON.parse(response);
           if(json.alert=='edit'){
            $('#logoatual').attr('src',json.rota)
            $('#form-logo').trigger('reset');
            $('#edit').hide('slow');
            $('#edit').show(1000);
            $('#edit').hide(2000);
            buscar_lab();
           }
           else{
            $('#noedit').hide('slow');
            $('#noedit').show(1000);
            $('#noedit').hide(2000);
            $('#form-logo').trigger('reset');
           }
        });
        e.preventDefault();
    })
    $(document).on('click','.apagar',(e)=>{
        funcion="apagar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nome = $(elemento).attr('labnome');
        const avatar = $(elemento).attr('labavatar');

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
                $.post('../controlador/LaboratorioControle.php',{id,funcion},(response)=>{
                    edit==false;
                   if(response=='apagado'){
                    swalWithBootstrapButtons.fire({
                        title: "Apagado!",
                        text: "O laboratório "+nome+" Foi apagado.",
                        icon: "success"
                      });
                      buscar_lab();
                   }
                   else{
                    swalWithBootstrapButtons.fire({
                        title: "Não se pode apagar!",
                        text: "O laboratório "+nome+" não foi apagado porque está sendo usado em um produto.",
                        icon: "error"
                      });
                   }
                })
            } else if (
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "O laborátorio "+nome+"  não foi apagado",
                icon: "error"
              });
            }
          });
    })
    $(document).on('click','.editar',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('labId');
        const nome = $(elemento).attr('labnome');
        $('#id_editar_lab').val(id);
        $('#nome-laboratorio').val(nome);
        edit=true;
    })
});