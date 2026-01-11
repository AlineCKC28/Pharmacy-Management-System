$(document).ready(function(){
   var tipo_usuario = $('#tipo_usuario').val();
   if(tipo_usuario==2){
    $('#button-crear').hide();
   }
    buscar_dados();
    var funcion;
    function buscar_dados(consulta){
        funcion='buscar_usuarios_adm';
        $.post('../controlador/UsuarioControle.php',{consulta,funcion},(response)=>{
            const usuarios = JSON.parse(response);
            let template='';
            usuarios.forEach(usuario=>{
                template+=` 
                <div usuarioId="${usuario.id}"class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0" _msttexthash="409435" _msthash="148">`;
                if(usuario.tipo_usuario==3){
                  template+=`<h1 class="badge badge-danger">${usuario.tipo}</h1> `;
                }
                if(usuario.tipo_usuario==1){
                  template+=`<h1 class="badge badge-warning">${usuario.tipo}</h1> `;
                }
                if(usuario.tipo_usuario==2){
                  template+=`<h1 class="badge badge-info">${usuario.tipo}</h1> `;
                }
                template+=`</div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b _msttexthash="228319" _msthash="149">${usuario.nome} ${usuario.apelidos}</b></h2>
                      <p class="text-muted text-sm" _msttexthash="1839136" _msthash="150"><b _istranslated="1">Sobre mim: </b> ${usuario.adicional} </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span><font _mstmutation="1" _msttexthash="1081652" _msthash="151"> DNI: ${usuario.dni}</font></li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span><font _mstmutation="1" _msttexthash="1081652" _msthash="151"> Idade: ${usuario.idade}</font></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><font _mstmutation="1" _msttexthash="1081652" _msthash="151"> Residêcia: ${usuario.residencia}</font></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><font _mstmutation="1" _msttexthash="324350" _msthash="152"> Telefone #: ${usuario.telefone}</font></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span><font _mstmutation="1" _msttexthash="1081652" _msthash="151"> Correio: ${usuario.correio}</font></li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-smile-wink"></i></span><font _mstmutation="1" _msttexthash="1081652" _msthash="151"> Sexo: ${usuario.sexo}</font></li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="${usuario.avatar}" alt="usuário-avatar" class="img-circle img-fluid" _mstalt="176397" _msthash="153">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  `;
                  if(tipo_usuario==3){
                    if(usuario.tipo_usuario!=3){
                      template+=`
                      <button class="apagar-usuario btn btn-danger mr-1 type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-window-close mr-1"></i> 
                      Eliminar
                    </button>
                    `;
                    }
                    if(usuario.tipo_usuario==2){
                      template+=`<button class="subir btn btn-primary ml-1 type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-sort-amount-up mr-1"></i> 
                      Subir
                    </button>
                    `;
                    }
                    if(usuario.tipo_usuario==1){
                      template+=`<button class="descer btn btn-secondary ml-1 type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-sort-amount-down mr-1"></i> 
                      Descer
                    </button>
                    `;
                    }
                  }
                  else{
                    if(tipo_usuario==1 && usuario.tipo_usuario!=1 && usuario.tipo_usuario!=3){
                      template+=`<button class="apagar-usuario btn btn-danger type="button" data-toggle="modal" data-target="#confirmar">
                      <i class="fas fa-window-close mr-1"></i> 
                      Eliminar
                    </button>
                    `;
                    }
                  }
                 template+=`
                  </div>
                </div>
              </div>
            </div>
                `;
            })
            $('#usuarios').html(template); 
        });
    }
    $(document).on('keyup','#buscar',function(){
        let valor = $(this).val();
        if(valor!=""){
            buscar_dados(valor);
        }
        else{
            buscar_dados();
        }
    });
    $('#form-crear').submit(e=>{
      let nome = $('#nome').val();
      let apelido = $('#apelido').val();
      let idade = $('#idade').val();
      let dni = $('#dni').val();
      let pass = $('#pass').val();
      funcion='crear_usuario';
      $.post('../controlador/UsuarioControle.php',{nome,apelido,idade,dni,pass, funcion},(response)=>{
        if(response=='add'){
          $('#add').hide('slow');
          $('#add').show(1000);
          $('#add').hide(2000);
          $('#form-crear').trigger('reset');
          buscar_dados();
        }
        else{
          $('#noadd').hide('slow');
          $('#noadd').show(1000);
          $('#noadd').hide(2000);
          $('#form-crear').trigger('reset');
        }
      });
      e.preventDefault();
    });
    $(document).on('click','.subir',(e)=>{
      const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr("usuarioId");
      funcion='subir';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $(document).on('click','.descer',(e)=>{
      const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr("usuarioId");
      funcion='descer';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $(document).on('click','.apagar-usuario',(e)=>{
      const elemento= $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id=$(elemento).attr("usuarioId");
      funcion='apagar-usuario';
      $('#id_user').val(id);
      $('#funcion').val(funcion);
    });
    $('#form-confirmar').submit(e=>{
      let pass=$('#oldpass').val();
      let id_usuario=$('#id_user').val();
      funcion=$('#funcion').val();
      $.post('../controlador/UsuarioControle.php',{pass,id_usuario,funcion},(response)=>{
        if(response=='subido'|| response=='descido' || response=='apagado'){
          $('#confirmado').hide('slow');
          $('#confirmado').show(1000);
          $('#confirmado').hide(2000);
          $('#form-confirmado').trigger('reset');
        }
        else{
          $('#recusado').hide('slow');
          $('#recusado').show(1000);
          $('#recusado').hide(2000);
          $('#form-confirmado').trigger('reset');
        }
        buscar_dados();
      });
      e.preventDefault();
    });   
})