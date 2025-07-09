    </main>
    
    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['empresa_id'])): ?>
    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="bi bi-bicycle text-primary"></i>
                        <strong>BikeSystem</strong> - Sistema de Gestão de Bicicletaria
                    </p>
                    <small class="text-muted">Versão 1.0.0</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        © <?= date('Y') ?> Todos os direitos reservados
                    </small>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    <script>
        checkJQuery(function($) {
        var produtosPrecos = {};
                $('.select2-ajax').select2({
                theme: 'bootstrap-5',
                width: '100%',
                minimumInputLength: 1,
                ajax: {
                    url: '<?= BASE_URL ?>/produto/api2',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        //console.log('Parâmetros enviados:', params);
                        return {
                            termo: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        //console.log('Resposta completa da API:', data);
                        params.page = params.page || 1;
                        return {
                            //results: data.produtos,
                            results: data.produtos.map(function(item) {
                                produtosPrecos[item.id] = item['data-preco'] || item.data_preco;
                                return {
                                    id: item.id,
                                    text: item.text || item.nome,
                                    // Garanta que o preço está sendo incluído
                                    'data-preco': item['data-preco'] || item.preco_venda || 5,
                                    'preco': item['data-preco'] || item.preco_venda || 5
                                };
                            }),
                            pagination: {
                                more: (params.page * 20) < data.total_count
                            }
                        };
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Erro na requisição AJAX:', {
                            status: textStatus,
                            error: errorThrown,
                            response: jqXHR.responseText
                        });
                        //alert('Erro ao carregar produtos. Verifique o console para detalhes.');
                    },
                    cache: true
                },
                placeholder: 'Digite o nome do produto...',
                language: {
                    noResults: function() {
                        return "Nenhum produto encontrado";
                    },
                    searching: function() {
                        return "Pesquisando...";
                    }
                }
            });

        });
    </script>


    
    
    <!-- Page specific scripts -->
    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($inline_scripts)): ?>
        <script>
            <?= $inline_scripts ?>
        </script>
    <?php endif; ?>
</body>
</html>

