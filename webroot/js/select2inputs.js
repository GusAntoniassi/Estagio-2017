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