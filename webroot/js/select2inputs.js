function _baseAutocomplete(url, $select) {
    $(function() {
        $.fn.select2.defaults.set('language', 'pt-BR');
        $select.data('ajax', {
            url: url,
            dataType: 'json',
            type: 'GET',
            data: function(params) {
                return {q: params.term}
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        console.log(item);
                        return {
                            text: item.name,
                            id: item.id,
                        }
                    })
                }
            }
        });
        $select.select2({
            ajax: $(this).data('ajax'),
            minimumInputLength: 1,
            placeholder: $select.attr('placeholder'),
        });
    });
}

function estadoAutocomplete(url) {
    _baseAutocomplete(url, $('select[name="estado_id"]'));
}

function fornecedorAutocomplete(url) {
    _baseAutocomplete(url, $('select[name="fornecedor_id"]'));
}

function produtoAutocompleteCompra(url) {
    $('select[name="produto_id"]').select2({
        ajax: {
            url: url,
            dataType: 'json',
            type: 'GET',
            data: function(params) {
                return {q: params.term}
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            nome: item.nome,
                            foto: item.foto,
                            possuiLote: item.possuiLote,
                        }
                    })
                }
            },
        },
        placeholder: $('select[name="produto_id"]').attr('placeholder'),
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: function(dados) {
            if (dados.loading) return null;
            var foto = (dados.foto ? dados.foto : 'http://via.placeholder.com/45x45')
            var html = '<div class="valign-wrapper">' +
                '<img src="' + foto + '" class="circle">' +
                '<span>&nbsp; ' + dados.nome + '</span>' +
                '</div>';

            return html;
        },
        templateSelection: function(dados) { // Formata os dados dentro do select
            // Se o ID não estiver setado, então a selection atual é o placeholder
            if (!dados.id) {
                return dados.text;
            }
            return dados.nome;
        },
    });
}