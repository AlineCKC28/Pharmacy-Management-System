$(document).ready(function(){
    calcularTotal();
     Contar_produtos();
     RecuperarLS_carrinho_compra(); 
    RecuperarLS_carrinho();
    $(document).on('click','.adicionar_carrinho',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id= $(elemento).attr('prodId');
      const nome = $(elemento).attr('prodNome');
      const concentracao=$(elemento).attr('prodConcentracao');
      const adicional=$(elemento).attr('prodAdicional');
      const preco=$(elemento).attr('prodPreco');
      const laboratorio=$(elemento).attr('prodLaboratorio');
      const tipo=$(elemento).attr('prodTipo');
      const apresentacao=$(elemento).attr('prodApresentacao');
      const avatar=$(elemento).attr('prodAvatar');
      const stock=$(elemento).attr('prodStock');
        const produto={
            id: id,
            nome: nome,
            concentracao:concentracao,
            adicional:adicional,
            preco:preco,
            laboratorio:laboratorio,
            tipo:tipo,
            apresentacao:apresentacao,
            avatar:avatar,
            stock:stock,
            quantidade:1
        }
        let id_produto;
        let produtos;
        produtos = RecuperarLS();
        produtos.forEach(prod => {
            if(prod.id===produto.id){
                id_produto=prod.id;
            }
        });
        if(id_produto === produto.id){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text:' O produto já exite!',
            })
        }
        else{
            template=`
            <tr prodId="${produto.id}">
            <td> ${produto.id}</td>
            <td>${produto.nome}</td>
            <td>${produto.concentracao}</td>
            <td>${produto.adicional}</td>
            <td>${produto.preco}</td>
            <td><button class="apagar-produto btn btn-danger"> <i class="fas fa-times-circle"></i></buttom></td>
            </tr>
            `;
            $('#lista').append(template);
            AdicionarLS(produto);
            let contador;
             Contar_produtos();
            
        }
    })
    $(document).on('click','.apagar-produto',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id= $(elemento).attr('prodId');
        elemento.remove();
        Eliminar_produto_LS(id);
         Contar_produtos();
         calcularTotal(); 
    })
    $(document).on('click','#esvaziar-carrinho',(e)=>{
       $('#lista').empty();
       EliminarLS();
        Contar_produtos();
       
    })
    $(document).on('click','#processar-pedido',(e)=>{
        Processar_pedido();
    })
    $(document).on('click','#processar_compra',(e)=>{
        processar_compra();
    })


    function RecuperarLS(){
        let produtos;
        if(localStorage.getItem('produtos')===null){
            produtos=[];
        }
        else{
            produtos= JSON.parse(localStorage.getItem('produtos'))
        }
        return produtos
    }
    function  AdicionarLS(produto){
        let produtos;
        produtos= RecuperarLS();
        produtos.push(produto);
        localStorage.setItem('produtos',JSON.stringify(produtos))
    }
    function RecuperarLS_carrinho(){
        let produtos,id_produto;
        produtos = RecuperarLS();
        funcion="buscar_id";
        produtos.forEach(produto => {
            id_produto=produto.id;
            $.post('../controlador/ProdutoControle.php',{funcion,id_produto},(response)=>{
                let template_carrinho='';
                let json = JSON.parse(response);
                template_carrinho=`
                    <tr prodId="${json.id}">
                        <td> ${json.id}</td>
                        <td>${json.nome}</td>
                        <td>${json.concentracao}</td>
                        <td>${json.adicional}</td>
                        <td>${json.preco}</td>
                        <td><button class="apagar-produto btn btn-danger"> <i class="fas fa-times-circle"></i></buttom></td>
                    </tr>
                `;
        $('#lista').append(template_carrinho);     
            })
        });
    }
    function Eliminar_produto_LS(id){
        let produtos;
        produtos = RecuperarLS();
        produtos.forEach(function(produto,indice){
            if(produto.id===id){
                produtos.splice(indice,1);
            }
        });
        localStorage.setItem('produtos',JSON.stringify(produtos));
    }
    function EliminarLS(){
        localStorage.clear();
    }
    function Contar_produtos(){
        let produtos;
        let contador=0;
        produtos=RecuperarLS();
        produtos.forEach(produto => {
            contador++;
        });
        $('#contador').html(contador);
    }
    function Processar_pedido(){
        let produtos;
        produtos= RecuperarLS();
        if(produtos.length === 0){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text:' O carrinho está vazio!',
            })
        }
        else{
            location.href = '../vista/adm_compra.php';
        }
    }
    function RecuperarLS_carrinho_compra(){
        let produtos,id_produto;
        produtos = RecuperarLS();
        funcion="buscar_id";
        produtos.forEach(produto => {
            id_produto=produto.id;
            $.post('../controlador/ProdutoControle.php',{funcion,id_produto},(response)=>{
                let template_compra='';
                let json = JSON.parse(response);
                template_compra=`
                    <tr prodId="${produto.id}" prodPreco=${json.preco}>
                        <td>${json.nome}</td>
                        <td>${json.stock}</td>
                        <td class="preco">${json.preco}</td>
                        <td>${json.concentracao}</td>
                        <td>${json.adicional}</td>
                        <td>${json.laboratorio}</td>
                        <td>${json.apresentacao}</td>
                        <td>
                        <input type="number" min="1" class="form-control quantidade_produto" value="${produto.quantidade}">
                        </td>
                        <td class="subtotais">
                        <h5>${json.preco*produto.quantidade}</h5>
                        </td>
                        <td><button class="apagar-produto btn btn-danger"> <i class="fas fa-times-circle"></i></buttom></td>
                </tr>
                `;
                    $('#lista-compra').append(template_compra);     
            })
        });
    }
    $(document).on('click','#actualizar',(e)=>{
        let produtos,precos;
        precos=document.querySelectorAll('.preco');
        produtos=RecuperarLS();
        produtos.forEach(function(produto,indice) {
            produto.preco=precos[indice].textContent;
        });
        localStorage.setItem('produtos',JSON.stringify(produtos));
        calcularTotal();
    })
    $('#cp').keyup((e)=>{
        let id,quantidade,produto,produtos,montos,preco;
        produto= $(this)[0].activeElement.parentElement.parentElement;
        id = $(produto).attr('prodId');
        preco = $(produto).attr('prodPreco');
        quantidade = produto.querySelector('input').value;
        montos= document.querySelectorAll('.subtotais');
        produtos = RecuperarLS();
        produtos.forEach(function(prod,indice){
            if(prod.id === id){
                prod.quantidade = quantidade;
                prod.preco = preco;
                montos[indice].innerHTML = ` <h5>${quantidade*  preco}</h5>`;
            }
        });
        localStorage.setItem('produtos',JSON.stringify(produtos));
        calcularTotal();
    })
    function calcularTotal(){
        let produtos,subtotal,com_iva,total_sem_desconto,pago,volto,desconto;
        let total=0,iva=0.18;
        produtos=RecuperarLS();
        produtos.forEach(produto => {
            let subtotal_produto= Number(produto.preco*produto.quantidade); 
            total=total+subtotal_produto;
        });
        pago=$('#pago').val();
        desconto=$('#desconto').val();
        total_sem_desconto=total.toFixed(2);
       com_iva=parseFloat(total*iva).toFixed(2);
       subtotal=(total-com_iva).toFixed(2);
       
       total=total-desconto;
       volto=pago-total;
        $('#subtotal').html(subtotal);
        $('#com_iva').html(com_iva);
        $('#total_sem_desconto').html(total_sem_desconto);
        $('#total').html(total.toFixed(2));
        $('#volto').html(volto.toFixed(2));
    }
    function processar_compra(){
        let nome,dni;
        nome=$('#cliente').val();
        dni=$('#dni').val();
        if(RecuperarLS().length ==0){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Não há produtos selecione alguns!",
            
              }).then(function(){
                location.href = '../vista/adm_catalogo.php'
              })
        }
        else if(nome==''){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Necessitamos o nome do cliente!",
            
              });
        }
        else{
            Verificar_stock().then(erro=>{
                if(erro==0){
                    Registar_compra(nome,dni);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "A compra foi realizada",
                        showConfirmButton: false,
                        timer: 1500
                      }).then(function(){
                        EliminarLS();
                        location.href = '../vista/adm_catalogo.php'
                      })
                }
                else{
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Há um conflito no stock de algum produto!",
                    
                      });
                }
            });
           
        }
    }

   async function Verificar_stock(){
        let produtos;
        funcion='verificar_stock';
        produtos=RecuperarLS();
        const response = await fetch('../controlador/ProdutoControle.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'funcion='+funcion+'&&produtos='+JSON.stringify(produtos)
        })
        let erro= await response.text();

        return erro;
    }
    function Registar_compra(nome,dni){
        funcion='registar_compra';
        let total=$('#total').get(0).textContent;
        let produtos=RecuperarLS();
        let json= JSON.stringify(produtos);
        $.post('../controlador/CompraControle.php',{funcion,total,nome,dni,json},(response)=>{
            console.log(response);
        })
    }
})