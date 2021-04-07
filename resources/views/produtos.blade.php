
@extends('layout.app', ["current" => "produtos"])


@section('body')
    <div class="card border">
        <div class="card-body">
            
            <h5 class="card-title">Cadastro de Produtos</h5>

            <table class="table table-ordered table-hover" id="tabelaProdutos">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Departamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>                  

                </tbody>
            </table>

            <div class="card-footer">
                <button class="btn btn-primary" role="button" onclick="novoProduto()">Novo produto</a>
            </div>
        
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formProduto">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo produto</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" class="form-control">
                        <div class="form-group">
                            <label for="nomeProduto" class="control-label">Nome do produto</label>
                            <input type="text" name="nomeProduto" id="nomeProduto" class="form-control" placeholder="Nome do produto">
                        </div>
                        <div class="form-group">
                            <label for="precoProduto" class="control-label">Preço do produto</label>
                            <input type="number" name="precoProduto" id="precoProduto" class="form-control" placeholder="Preço do produto">
                        </div>
                        <div class="form-group">
                            <label for="quantidadeProduto" class="control-label">Quantidade do produto</label>
                            <input type="number" name="quantidadeProduto" id="quantidadeProduto" class="form-control" placeholder="Quantidade do produto">
                        </div>
                        <div class="form-group">
                            <label for="categoriaProduto" class="control-label">Categoria do produto</label>
                            <select name="categoriaProduto" id="categoriaProduto" class="form-control"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="submit" class="btn btn-secondary" data-dismiss="">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@stop


@section('javascript')
    <script type="text/javascript">

        $.ajaxSetup([
            headers = {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        ]);

        function novoProduto(){
            $('#id').val('');
            $('#nomeProduto').val('');
            $('#precoProduto').val('');
            $('#quantidadeProduto').val('');
            $('#dlgProdutos').modal('show');
        }

        function carregarCategorias(){
            $.getJSON('/api/categorias', function(data){
                for(i=0; i<data.length; i++){
                    opcao = '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                    $('#categoriaProduto').append(opcao);
                }
            });
        }

        function carregarProdutos(){
            $.getJSON('/api/produtos', function(data){
                for(i=0; i<data.length; i++){
                    linha = montarLinha(data[i]);
                    $('#tabelaProdutos>tbody').append(linha);
                }
            });
        }

        function montarLinha(produto){
            var linha = "<tr>" + 
                "<td>" + produto.id + "</td>" +
                "<td>" + produto.nome + "</td>" +
                "<td>" + produto.estoque + "</td>" +
                "<td>" + produto.preco + "</td>" +
                "<td>" + produto.categoria_id + "</td>" +
                "<td>" + 
                    "<button class='btn btn-sm btn-primary' onclick='editar("+ produto.id +")'> Editar </button> "+    
                    "<button class='btn btn-sm btn-danger' onclick='remover("+ produto.id +")'> Apagar </button>"+    
                "</td>" +
                "</tr>"
            return linha;
        }

        function editar(id){
            $.getJSON('api/produtos/'+id+'/edit', function(data){
                $('#id').val(data.id);
                $('#nomeProduto').val(data.nome);
                $('#precoProduto').val(data.preco);
                $('#quantidadeProduto').val(data.estoque);
                $('#categoriaProduto').val(data.categoria_id);
                $('#dlgProdutos').modal('show');
            });
        }

        function remover(id){
            $.ajax({
                type:'DELETE',
                url:'/api/produtos/'+id,
                context: this,
                success:function(){
                    linhas = $('#tabelaProdutos>tbody>tr');
                    e = linhas.filter(function(i, elemento){
                        return elemento.cells[0].textContent == id;
                    });
                    if(e)
                        e.remove();
                },
                error:function(){

                }
            })
        }

        function criarProduto(){
            prod = {
                nome: $('#nomeProduto').val(),
                preco: $('#precoProduto').val(),
                estoque: $('#quantidadeProduto').val(),
                categoria_id: $('#categoriaProduto').val()
            };

            $.post('/api/produtos', prod, function(data){
                produto = JSON.parse(data);
                linha = montarLinha(produto);
                $('#tabelaProdutos>tbody').append(linha);
            });
        }

        function editarProduto(){
            prod = {
                id: $('#id').val(),
                nome: $('#nomeProduto').val(),
                preco: $('#precoProduto').val(),
                estoque: $('#quantidadeProduto').val(),
                categoria_id: $('#categoriaProduto').val()
            };

            $.ajax({
                type:'PUT',
                url:'api/produtos/'+prod.id,
                context: this,
                data: prod,
                success:function(data){
                    prod = JSON.parse(data);
                    linhas = $('#tabelaProdutos>tbody>tr');
                    e = linhas.filter(function(i,elemento){
                        return elemento.cells[0].textContent == prod.id;
                    });
                    if(e)
                        e[0].cells[0].textContent = prod.id;
                        e[0].cells[1].textContent = prod.nome;
                        e[0].cells[2].textContent = prod.estoque;
                        e[0].cells[3].textContent = prod.preco;
                        e[0].cells[4].textContent = prod.categoria_id;

                },
                error:function(){

                }
            })
        }

        $("#formProduto").submit( function(event) {
            event.preventDefault();
            
            if($('#id').val() != ""){
                editarProduto();
            }else{
                criarProduto();
            }
                
            $("#dlgProdutos").modal('hide');
        });

        $(function(){
            carregarCategorias();
            carregarProdutos();
        });

    </script>
@stop
