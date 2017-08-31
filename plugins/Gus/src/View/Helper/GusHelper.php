<?php
namespace Gus\View\Helper;
use Cake\View\Helper;
use Cake\Routing\Router;
use Cake\View\Helper\FormHelper as FormHelper;

class GusHelper extends FormHelper {
	public $helpers = ['Url', 'Html', 'Paginator'];
	
	public function __construct(\Cake\View\View $View, array $config = []) {
		parent::__construct($View, $config);
		$this->setTemplates([
			'inputContainer' => '<div class="input-field {{type}}{{required}} {{div}}">{{content}}</div>',
			'inputContainerError' => '<div class="input-field {{type}}{{required}} {{div}} has-error">{{content}}{{error}}</div>',
			'submitContainer' => '<div class="input-field submit {{div}}">{{content}}</div>',
			'textarea' => '<textarea name="{{name}}" class="materialize-textarea {{class}}" {{attrs}}>{{value}}</textarea>',
            'checkboxFormGroup' => '{{label}}',
            'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
            'radio' => '<input type="radio" class="with-gap" name="{{name}}" value="{{value}}"{{attrs}}>',
            'radioWrapper' => '{{label}}',
		]);
	}
	
	public function materialIcon($nome) {
		return $this->Html->tag('i', h($nome), ['class' => 'material-icons']);
	}
	
	public function control($fieldName, array $options = []) {
		if (!empty($options['div'])) {
			$options['templateVars']['div'] = $options['div'];
			unset($options['div']);
		} else if (isset($options['div']) && $options['div'] === FALSE) {
            $options['templates']['inputContainer'] = '{{content}}';
        }

		// Se for um campo do tipo status (e não estiver declarado type radio)
		if (($fieldName == 'status' || preg_match('/.*?\.status/', $fieldName)) && (empty($options['type']) || $options['type'] == 'rsadio')) {
		    $options['templateVars']['div'] .= ' switch-wrapper';
		    $this->setTemplates([
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
		        'nestingLabel' => '{{hidden}}<div class="switch"><label{{attrs}}><span class="lever-inativo">Inativo</span>{{input}}<span class="lever"></span><span class="lever-ativo">Ativo</span></label></div>'
            ]);
        } else {
		    $this->setTemplates([
                'checkbox' => '<input type="checkbox" name="{{name}}" class="filled-in" value="{{value}}"{{attrs}}>',
                'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
            ]);
        }
		
		return parent::control($fieldName, $options);
	}

	public function button($title, array $options = []) {
        $button = '';
        $div = false;
	    if (!empty($options['div'])) {
	        $button .= '<div class="' . $options['div'] . '">';
            $options['div'] = null;
            $div = true;
        }

        $button .= parent::button($title, $options);

	    if ($div) {
	        $button .= '</div>';
        }

        return $button;
    }

    public function selectExtends($fieldName, array $options = [], array $settings = []) {
	    $attributes = (empty($settings['attributes']) ? array() : $settings['attributes']);

	    if (!empty($options)) {
            $attributes = array_merge([
                'data-select-2'
            ], $attributes);
        }

	    $settings = array_merge([
	        'refreshParams' => []
        ], $settings);

	    if (empty($settings['controller'])) {
            if (strpos($fieldName, '.') !== FALSE) {
                $settings['controller'] = substr($fieldName, 0, strpos($fieldName, '.'));
            } else {
                $settings['controller'] = $fieldName;
            }
	    }

        $settings['linkEdit'] = Router::url(['controller' => $settings['controller'], 'action' => 'edit'], true);
        $settings['linkAdd'] = Router::url(['controller' => $settings['controller'], 'action' => 'add'], true);
        $routeRefresh = ['controller' => $settings['controller'], 'action' => 'getAll'];
        foreach ($settings['refreshParams'] as $param) {
            $routeRefresh[] = $param;
        }
        $settings['linkRefresh'] = Router::url($routeRefresh, true);

        if (!isset($settings['label'])) {
            $settings['label'] = [];
        }

        $labelText = (is_array($settings['label']) ? $settings['label']['text'] : $settings['label']);

        $select =
            '<div class="input-group ' . (empty($settings['div']) ? '' : $settings['div']) . ' ' . $fieldName . '">' .
                parent::label($fieldName, $labelText, $settings['label']) .
                parent::select($fieldName, $options, $attributes) .
                '<span class="input-group-btn">' .
                    '<a class="btn btn-small waves-effect waves-light refresh" data-href="' . $settings['linkRefresh'] . '" onclick="return refreshSelect(event.target || event.srcElement);">' . $this->materialIcon('autorenew') . '</a>' .
                    '<a class="btn btn-small waves-effect waves-light edit" href="' . $settings['linkEdit'] . '" onclick="return extendEdit(event);">' . $this->materialIcon('edit') . '</a>' .
                    '<a class="btn btn-small waves-effect waves-light add" href="' . $settings['linkAdd'] . '" onclick="return extendAdd(event);">' . $this->materialIcon('add') . '</a>' .
                '</span>' .
            '</div>';
	    return $select;
    }

    public function selectAjaxExtends($fieldName, array $settings = [], array $options = []) {
	    return $this->selectExtends($fieldName, $options, $settings);
    }

	public function paginatorControls() {
		if (!empty($this->Paginator->numbers())) {
			return
				$this->Paginator->first() .
				$this->Paginator->prev() .
				$this->Paginator->numbers() .
				$this->Paginator->next() .
				$this->Paginator->last();
		} else {
			return '';
		}
	}

	public function formataStatus($status) {
	    if (!empty($status)) {
            return '<span class="ativo">Ativo</span>';
        } else {
            return '<span class="inativo">Inativo</span>';
        }
    }

    public function formataBoolean($status) {
        if (!empty($status)) {
            return '<span class="ativo">Sim</span>';
        } else {
            return '<span class="inativo">Não</span>';
        }
    }

    public function getStatusOptions() {
	    return [
	        '' => 'Todos',
	        1 => 'Ativo',
            0 => 'Inativo'
        ];
    }

    public function getBooleanOptions() {
        return [
            '' => 'Todos',
            1 => 'Sim',
            0 => 'Não'
        ];
    }

    public function tipoPessoaPorExtenso($tipo) {
	    return ($tipo == 'F' ? 'Física' : 'Jurídica');
    }

    public function getPessoaLabel($campo, $tipoPessoa) {
	    switch ($campo) {
            case 'nome_razaosocial':
                return ($tipoPessoa == 'F' ? 'Nome' : 'Razão social');
            case 'sobrenome_nomefantasia':
                return ($tipoPessoa == 'F' ? 'Sobrenome' : 'Nome fantasia');
            case 'cpfcnpj':
                return ($tipoPessoa == 'F' ? 'CPF' : 'CNPJ');
        }
    }
}
