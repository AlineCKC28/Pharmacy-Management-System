$(document).ready(function(){
    var funcion='';
    var id_usuario = $('#id_usuario').val();
    var edit=false;
    buscar_usuario(id_usuario);
    function buscar_usuario(dado) {
        funcion='buscar_usuario';
        $.post('../controlador/UsuarioControle.php',{dado,funcion},(response)=>{
            let nome='';
            let apelidos='';
            let idade='';
            let dni='';
            let tipo='';
            let telefone='';
            let residencia='';
            let correio='';
            let sexo='';
            let adicional='';
            const usuario = JSON.parse(response); 
            nome+=`${usuario.nome}`;
            apelidos+=`${usuario.apelidos}`;
            idade+=`${usuario.idade}`;
            dni+=`${usuario.dni}`;
            if(usuario.tipo=='Root'){
                tipo+=`<h1 class="badge badge-danger">${usuario.tipo}</h1> `;
              }
              if(usuario.tipo=='Administrador'){
                tipo+=`<h1 class="badge badge-warning">${usuario.tipo}</h1> `;
              }
              if(usuario.tipo=='Tecnico'){
                tipo+=`<h1 class="badge badge-info">${usuario.tipo}</h1> `;
              }
            telefone+=`${usuario.telefone}`;
            residencia+=`${usuario.residencia}`;
            correio+=`${usuario.correio}`;
            sexo+=`${usuario.sexo}`;
            adicional+=`${usuario.adicional}`;
            $('#nome_us').html(nome);
            $('#apelidos_us').html(apelidos);
            $('#idade').html(idade);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);
            $('#telefone_us').html(telefone);
            $('#residencia_us').html(residencia);
            $('#correio_us').html(correio);
            $('#sexo_us').html(sexo);
            $('#adicional_us').html(adicional);
            $('#avatar2').attr('src',usuario.avatar);
            $('#avatar2').attr('src',usuario.avatar);
            $('#avatar3').attr('src',usuario.avatar);
            $('#avatar4').attr('src',usuario.avatar);
        })
        }
        $(document).on('click','.edit',(e)=>{
            funcion='capturar_dados';
            edit=true;
            $.post('../controlador/UsuarioControle.php',{funcion,id_usuario},(response)=>{
                const usuario = JSON.parse(response);
                $('#telefone').val(usuario.telefone);
                $('#residencia').val(usuario.residencia);
                $('#correio').val(usuario.correio);
                $('#sexo').val(usuario.sexo);
                $('#adicional').val(usuario.adicional);
            })
        });
        $('#form-usuario').submit(e=>{
            if(edit==true){
                let telefone=$('#telefone').val();
                let residencia=$('#residencia').val();
                let correio=$('#correio').val();
                let sexo=$('#sexo').val();
                let adicional=$('#adicional').val();
                funcion='editar_usuario';
                $.post('../controlador/UsuarioControle.php',{id_usuario,funcion,telefone,residencia,correio,sexo,adicional},(response)=>{
                    if(response=='editado'){
                        $('#editado').hide('slow');
                        $('#editado').show(1000);
                        $('#editado').hide(2000);
                        $('#form-usuario').trigger('reset');
                    }
                    edit=false;
                    buscar_usuario(id_usuario);
                })
            }
            else{
                $('#naoeditado').hide('slow');
                $('#naoeditado').show(1000);
                $('#naoeditado').hide(2000);
                $('#form-usuario').trigger('reset');
            }
            e.preventDefault();
        });
        $('#form-pass').submit(e=>{
            let oldpass=$('#oldpass').val();
            let newpass=$('#newpass').val();
            funcion='mudar_senha';
            $.post('../controlador/UsuarioControle.php',{id_usuario,funcion,oldpass,newpass},(response)=>{
               if(response=='update'){
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-pass').trigger('reset');
                buscar_usuario(id_usuario);
               }
               else{
                $('#noupdate').hide('slow');
                $('#noupdate').show(1000);
                $('#noupdate').hide(2000);
                $('#form-pass').trigger('reset');
               }
            })
            e.preventDefault();
})
$('#form-foto').submit(e=>{
    let formData = new FormData($('#form-foto')[0]);
    $.ajax({
        url:'../controlador/UsuarioControle.php',
        type:'POST',
        data:formData,
        cache:false,
        processData:false,
        contentType:false
    }).done(function(response){
       const json =JSON.parse(response);
       if(json.alert=='edit'){
        $('#avatar1').attr('src',json.rota);
        $('#edit').hide('slow');
        $('#edit').show(1000);
        $('#edit').hide(2000);
        $('#form-foto').trigger('reset');
       }
      else{
        $('#noedit').hide('slow');
        $('#noedit').show(1000);
        $('#noedit').hide(2000);
        $('#form-foto').trigger('reset');
      }
    });
    e.preventDefault();
})
})
