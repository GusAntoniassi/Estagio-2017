function pulse1x($obj) {
	$obj.addClass('pulse');
	window.setTimeout(function() {
		$obj.removeClass('pulse');
	}, 1000);
}
// Retirado de: http://www.devmedia.com.br/validar-cpf-com-javascript/23916
function validaCPF(cpf) {
	// Remove os pontos e traços
    cpf = cpf.replace(/[^\d]+/g,'');
    if (cpf == '' || cpf.length != 11)
        return false;

    // Verificar se todos os dígitos são os mesmos
	if (/^([0-9])\1*$/.test(cpf)) return false;

	var Soma;
	var Resto;
	Soma = 0;

	for (i=1; i<=9; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11))  Resto = 0;
	if (Resto != parseInt(cpf.substring(9, 10)) ) return false;

	Soma = 0;
	for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (12 - i);
	Resto = (Soma * 10) % 11;

	if ((Resto == 10) || (Resto == 11))  Resto = 0;
	if (Resto != parseInt(cpf.substring(10, 11) ) ) return false;
	return true;
}
// Retirado de: http://www.geradorcnpj.com/javascript-validar-cnpj.htm
function validaCNPJ(cnpj) {
	cnpj = cnpj.replace(/[^\d]+/g,'');

	if (cnpj == '' || cnpj.length != 14)
		return false;

	// Elimina CNPJs invalidos conhecidos
    if (/^([0-9])\1*$/.test(cnpj)) return false;

	// Valida DVs
	tamanho = cnpj.length - 2
	numeros = cnpj.substring(0,tamanho);
	digitos = cnpj.substring(tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(0))
		return false;

	tamanho = tamanho + 1;
	numeros = cnpj.substring(0,tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(1))
		return false;

	return true;
}
function maskInputs() {
    // Máscaras
    $('[data-type="date"]').mask('99/99/9999').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        scrollMonth: false,
        scrollInput: false,
    });
    $('[data-type="datetime"]').mask('99/99/9999 99:99:99').datetimepicker({
        format: 'd/m/Y h:i:s',
        scrollMonth: false,
        scrollInput: false,
    });
    $('[data-type="time"]').mask('99:99:99').datetimepicker({
        datepicker: false,
        format: 'h:i:s',
        scrollMonth: false
    });
    $('[data-type="cpf"]').mask('999.999.999-99');
    $('[data-type="cnpj"]').mask('99.999.999/9999-99');
    $('.required input, .required select, .required textarea').each(function () {
        if ($(this).attr('required') == null) {
            $(this).attr('required', 'required');
        }
    });
    $('[data-type="cep"]').mask('99999-999');

    // Behavior personalizado para telefone com múltiplos dígitos
    var SPMaskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
			field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};

    $('[data-type="phone"]').mask(SPMaskBehavior, spOptions);

    $('[data-type="money"]').mask('#.##0,00', {reverse: true}).removeAttr('maxlength');
    $('[data-select-2]').addClass('browser-default').select2();
    $('[data-select-2-ajax]').addClass('browser-default').select2();
    $('[data-material-select]').each(function() {
    	$(this).siblings('label').addClass('active');
    	$(this).material_select();
	});

}
/* ===== Condições de esconder ===== */

function checkHideConditions(conditions) {

}
/* ============= Helpers ================== */
String.prototype.appendParameter = function(key, value) {
	return this + ((this.indexOf('?') != -1) ? '&' : '?') + encodeURIComponent(key) + '=' + encodeURIComponent(value);
}
/* ============= Extends * ================ */
function listenFocus(e) {
    window.onfocus = function() {
        refreshSelect(e);
        // Reseta os listeners de focus e blur
        window.onfocus = function() {};
    }
}
function extendAdd(e) {
	e = e || window.event;
	var target = e.target || e.srcElement;
	var link = $(target).closest('a').attr('href');
	link = link.toString().appendParameter('extends', 'true');

	window.open(link);
    listenFocus($(target).closest('.input-group').find('.btn.refresh'));
    e.preventDefault();
	return false;
}
function extendEdit(e) {
    e = e || window.event;
    var target = e.target || e.srcElement;
    var link = $(target).closest('a').attr('href');
    var select = $(target).closest('.input-group').find('select');
    if (!$(select).val()) { // Se não tiver selecionado nenhuma opção, não fazer nada.
		e.preventDefault();
    	return;
	}
	link += '/' + $(select).val();
	link = link.appendParameter('extends', 'true');

    window.open(link);
	listenFocus($(target).closest('.input-group').find('.btn.refresh'));
    e.preventDefault();
    return false;
}
function refreshSelect(target) {
    var $select = $(target).closest('.input-group').find('select');
    var $refresh = $(target).closest('.btn.refresh');
    var data = {};
    if ($select.hasClass('select2ajax')) {
		data = {ajax_id: $select.val()};
	}

    $.ajax({
        url: $refresh.attr('data-href'),
		type: 'GET',
        data: data,
    }).done(function(data) {
        console.log(data);
        var json = JSON.parse(data);
        data = [];
        if (json) {
            for (var id in json) {
                data.push({'id': id, 'text': json[id]});
            }
        }

        var selected = $select.val();
        if ($select.hasClass('select2ajax')) {
			$select.empty().select2({
				data: data,
				ajax: $select.data('ajax'),
                minimumInputLength: 1,
                placeholder: $('select[name="estado_id"]').attr('placeholder')
			});
		} else {
			$select.empty().select2({
				data: data
			});
		}
        $select.val(selected);
        $select.trigger("change").trigger('refresh');
    }).fail(function() {
        alert('Erro ao atualizar o select');
    });

    console.log(target);
    return false;
}

function atualizaBotaoFixo() {
	/* Atualização do botão fixo */
    var checkeds = $('table.index tbody :checkbox:checked').length;
    // Apenas um selecionado - mostrar edit com os botões adicionais
    if (checkeds == 1) {
        $('.botao-fixo .adicionais').removeClass('hide');
        $('.botao-fixo .edit').removeClass('hide');
        $('.botao-fixo .add, .botao-fixo .deleteAll').addClass('hide');

        // Remover o link do botão fixo
        $('.botao-fixo a').removeAttr('href');

        // Colocar o link nos botões adicionais
        $('.botao-fixo .adicionais a.edit').attr('href', editLink.replace('--id--', $('table.index :checkbox:checked').val()));
        $('.botao-fixo .adicionais a.view').attr('href', viewLink.replace('--id--', $('table.index :checkbox:checked').val()));

        pulse1x($('.botao-fixo .btn-floating'));
    } else {
        $('.botao-fixo .adicionais').addClass('hide');
        // Mais de um selecionado - mostrar excluir
        if (checkeds > 1) {
            if ($('.botao-fixo .deleteAll').hasClass('hide')) {
                $('.botao-fixo .deleteAll').removeClass('hide');
                $('.botao-fixo .add, .botao-fixo .edit').addClass('hide');

                // Remover o link do botão fixo
                $('.botao-fixo a').removeAttr('href');

                pulse1x($('.botao-fixo .btn-floating'));
            }
            // Nenhum selecionado - mostrar add
        } else {
            $('.botao-fixo .add').removeClass('hide');
            $('.botao-fixo .edit, .botao-fixo .deleteAll').addClass('hide');

            // Atribuir o link ao botão fixo
            $('.botao-fixo a').attr('href', addLink);

            pulse1x($('.botao-fixo .btn-floating'));
        }
    }
}

$.fn.select2.defaults.set('language', 'pt-BR');
$(document).ready(function() {
	jQuery.datetimepicker.setLocale('pt-BR');
	maskInputs();

    /* Seleção de linhas da tabela */
	// Se atualizou ou voltou a página com algumas caixas marcadas, adicionamos a classe aqui
	$('table.index :checkbox:checked').each(function() {
		$(this).addClass('active');
	})
	// Clique na check-all
	$('table.index').on('click', '#check-all', function() {
		$('table.index input:checkbox').prop('checked', $(this).prop('checked')).change();
		$('table.index tbody tr').toggleClass('active', $(this).prop('checked'));
	});
	// Clique na checkbox
	$('table.index tbody').on('click', ':checkbox', function() {
		var $tr = $(this).closest('tr');
		$tr.toggleClass('active');
		$(this).prop('checked', $tr.hasClass('active')).change();
	});
	// Clique em qualquer linha
	$('table.index tbody').on('click', 'tr', function(e) {
		// Se não for na coluna das checkboxes
		if (!$(e.target).is(':checkbox, label[for^="check"], a, button, i.material-icons')) {
			$(this).toggleClass('active');
			$(this).find('input:checkbox').prop('checked', $(this).hasClass('active')).change();
		}
	});

	// Quando houver uma mudança na checkbox
	$('table.index tbody').on('change', ':checkbox', atualizaBotaoFixo);
	if ($('.botao-fixo').length) {
		atualizaBotaoFixo();
	}

	// Clique no botão fixo, add ou delete
	$('.botao-fixo').on('click', '.delete, .deleteAll', function(e) {
		if (confirm('Deseja realmente excluir o(s) registro(s) selecionados?')) {
			$('table.index tbody :checkbox:checked').each(function() {
				$('#form-delete').append('<input name="ids[]" value="' + $(this).val() + '" />');
			});
			$('#form-delete').submit();
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
	});
});
