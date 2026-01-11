$(document).ready(function(){
  $('#cat-carrinho').show();
    mostrar_lotes_risco();
    buscar_produto();
    function buscar_produto(consulta){
        funcion="buscar";
        $.post('../controlador/ProdutoControle.php',{consulta,funcion},(response)=>{
            const produtos = JSON.parse(response);
            let template='';
            produtos.forEach(produto =>{
                template+=`
                <div prodId="${produto.id}"prodStock="${produto.stock}"prodNome="${produto.nome}"prodPreco="${produto.preco}"prodConcentracao="${produto.concentracao}"prodAdicional="${produto.adicional}"prodLaboratorio="${produto.laboratorio_id}"prodTipo="${produto.tipo_id}"prodApresentacao="${produto.apresentacao_id}"prodAvatar="${produto.avatar}"class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  <i class="fas fa-lg fa-cubes mr-1"></i>${produto.stock}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                    <h2 class="lead"><b>Código: ${produto.id}</b></h2>
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
                    
                    <button class="adicionar_carrinho btn btn-sm btn-primary">
                      <i class="fas fa-plus-square mr-2"></i> Adicionar ao carrinho
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
    function mostrar_lotes_risco(){
        funcion="buscar";
        $.post('../controlador/LoteControle.php',{funcion},(response)=>{
            const lotes= JSON.parse(response);
            let template='';
            lotes.forEach(lote =>{
                if(lote.estado=='warning'){
                    template+=`
                <tr class="table-warning">
                <td>${lote.id}</td>
                <td>${lote.nome}</td>
                <td>${lote.stock}</td>
                <td>${lote.laboratorio}</td>
                <td>${lote.apresentacao}</td>
                <td>${lote.fornecedor}</td>
                <td>${lote.mes}</td>
                <td>${lote.dia}</td>
                </tr>
                `;
                }
                if(lote.estado=='danger'){
                    template+=`
                <tr class="table-danger">
                <td>${lote.id}</td>
                <td>${lote.nome}</td>
                <td>${lote.stock}</td>
                <td>${lote.laboratorio}</td>
                <td>${lote.apresentacao}</td>
                <td>${lote.fornecedor}</td>
                <td>${lote.mes}</td>
                <td>${lote.dia}</td>
                </tr>
                `;
                }
                
            });
            $('#lotes').html(template);
        })
    }
})