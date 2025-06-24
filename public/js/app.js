// Custom JavaScript - Sistema de Gestão de Bicicletaria

$(document).ready(function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializar popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Auto-hide alerts após 5 segundos
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Confirmação de exclusão
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var item = $(this).data('item') || 'este item';
        
        if (confirm('Tem certeza que deseja excluir ' + item + '?')) {
            window.location.href = url;
        }
    });
    
    // Formatação de moeda
    $('.currency').mask('#.##0,00', {
        reverse: true,
        translation: {
            '#': {pattern: /[0-9]/}
        }
    });
    
    // Formatação de números
    $('.number').mask('000000000');
    
    // Formatação de telefone
    $('.phone').mask('(00) 00000-0000');
    
    // Busca em tempo real
    $('.search-input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        var target = $(this).data('target');
        
        $(target + ' tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Adicionar fade-in aos cards
    $('.card').addClass('fade-in');
});

// Funções utilitárias
var BikeSystem = {
    // Formatar moeda
    formatCurrency: function(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    },
    
    // Formatar data
    formatDate: function(date) {
        return new Intl.DateTimeFormat('pt-BR').format(new Date(date));
    },
    
    // Mostrar loading
    showLoading: function(element) {
        $(element).html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Carregando...</span></div>');
    },
    
    // Esconder loading
    hideLoading: function(element, originalText) {
        $(element).html(originalText);
    },
    
    // Mostrar toast
    showToast: function(message, type = 'success') {
        var toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        // Criar container de toasts se não existir
        if (!$('#toast-container').length) {
            $('body').append('<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }
        
        var $toast = $(toastHtml);
        $('#toast-container').append($toast);
        
        var toast = new bootstrap.Toast($toast[0]);
        toast.show();
        
        // Remover toast após ser escondido
        $toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    },
    
    // Confirmar ação
    confirm: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },
    
    // Fazer requisição AJAX
    ajax: function(url, data, success, error) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: success || function(response) {
                console.log('Success:', response);
            },
            error: error || function(xhr, status, errorThrown) {
                console.error('Error:', errorThrown);
                BikeSystem.showToast('Erro na requisição', 'danger');
            }
        });
    }
};

// Orçamento - Funções específicas
var Orcamento = {
    // Adicionar item ao orçamento
    adicionarItem: function(path = '') {
        var template = $('#item-template').html();
        var index = $('.orcamento-item').length;
        
        
        template = template.replace(/\[INDEX\]/g, index);
        $('#itens-orcamento').append(template);
        
        // Inicializar eventos no novo item
        this.initItemEvents($('.orcamento-item').last(), path);
    },
    
    // Remover item do orçamento
    removerItem: function(button) {
        $(button).closest('.orcamento-item').remove();
        this.calcularTotal();
    },
    
    // Calcular subtotal do item
    calcularSubtotal: function(item) {
        var quantidade = parseFloat($(item).find('.quantidade').val()) || 0;
        var preco = parseFloat($(item).find('.preco').val()) || 0;
        var subtotal = quantidade * preco;
        
        $(item).find('.subtotal').text(BikeSystem.formatCurrency(subtotal));
        
        this.calcularTotal();
    },
    
    // Calcular total do orçamento
    calcularTotal: function() {
        var total = 0;
        
        $('.orcamento-item').each(function() {
            var quantidade = parseFloat($(this).find('.quantidade').val()) || 0;
            var preco = parseFloat($(this).find('.preco').val()) || 0;
            total += quantidade * preco;
        });
        
        $('#valor-total').text(BikeSystem.formatCurrency(total));
    },
    
    // Buscar preço do produto
    buscarPrecoProduto: function(select, path = '') {
        var produtoId = $(select).val();
        var item = $(select).closest('.orcamento-item');
        var tabelaPreco = $('#tabela_preco').val();
        
        if (produtoId) {
            $.get(path+'/orcamento/apiPrecoProduto/' + produtoId + '/' + tabelaPreco, function(response) {
                if (response.preco) {
                    item.find('.preco').val(response.preco);
                    Orcamento.calcularSubtotal(item);
                } else {
                    item.find('.preco').val('');
                    Orcamento.calcularSubtotal(item);
                }
            });
        }
    },
    
    // Inicializar eventos do item
    initItemEvents: function(item, path = '') {
        var self = this;
        item.find('.produto-select').on('change', function() {
            self.buscarPrecoProduto(this, path);
        });
        
        item.find('.quantidade, .preco').on('input', function() {
            self.calcularSubtotal(item);
        });
        
        item.find('.btn-remove-item').on('click', function() {
            self.removerItem(this);
        });
    }
};

// Estoque - Funções específicas
var Estoque = {
    // Buscar quantidade em estoque
    buscarQuantidade: function(produtoId, callback, path) {
        if (produtoId) {
            
            $.get(path + '/estoque/api/' + produtoId, function(response) {
                if (callback) {
                    callback(response.quantidade);
                }
            });
        }
    },
    
    // Atualizar display de quantidade
    atualizarQuantidade: function(select) {
        var produtoId = $(select).val();
        var display = $(select).closest('.form-group').find('.quantidade-atual');
        
        if (produtoId) {
            this.buscarQuantidade(produtoId, function(quantidade) {
                display.text('Quantidade atual: ' + quantidade);
                display.removeClass('d-none');
            });
        } else {
            display.addClass('d-none');
        }
    }
};

// Produto - Funções específicas
var Produto = {
    // Buscar produtos via AJAX
    buscar: function(termo, callback) {
        $.get('/produto/api', { search: termo }, function(response) {
            if (callback) {
                callback(response);
            }
        });
    },
    
    // Autocomplete de produtos
    initAutocomplete: function(selector) {
        $(selector).on('input', function() {
            var termo = $(this).val();
            var input = this;
            
            if (termo.length >= 2) {
                Produto.buscar(termo, function(produtos) {
                    // Implementar dropdown de sugestões
                    console.log('Produtos encontrados:', produtos);
                });
            }
        });
    }
};

