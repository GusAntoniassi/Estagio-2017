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
			'inputContainerError' => '<div class="input-field {{type}}{{required}} {{div}} error">{{content}}{{error}}</div>',
			'submitContainer' => '<div class="input-field submit {{div}}">{{content}}</div>',
			'textarea' => '<textarea name="{{name}}" class="materialize-textarea {{class}}" {{attrs}}>{{value}}</textarea>',
            'checkbox' => '<input type="checkbox" name="{{name}}" class="filled-in" value="{{value}}"{{attrs}}>',
            'checkboxFormGroup' => '{{label}}',
            'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
            'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
		]);
	}
	
	public function materialIcon($nome) {
		return $this->Html->tag('i', h($nome), ['class' => 'material-icons']);
	}
	
	public function control($fieldName, array $options = []) {
		if (!empty($options['div'])) {
			$options['templateVars']['div'] = $options['div'];
			unset($options['div']);
		}

		if ($fieldName == 'status') {
		    $options['templateVars']['div'] .= ' switch-wrapper';
		    $this->setTemplates([
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
		        'nestingLabel' => '{{hidden}}<div class="switch"><label{{attrs}}><span class="lever-inativo">Inativo</span>{{input}}<span class="lever"></span><span class="lever-ativo">Ativo</span></label></div>'
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

	    $attributes = array_merge([
	        'data-select-2'
        ], $attributes);


	    if (empty($settings['controller'])) {
            if (strpos($fieldName, '.') !== FALSE) {
                $settings['controller'] = substr($fieldName, 0, strpos($fieldName, '.'));
            } else {
                $settings['controller'] = $fieldName;
            }
	    }

        $settings['linkEdit'] = Router::url(['controller' => $settings['controller'], 'action' => 'edit'], true);
        $settings['linkAdd'] = Router::url(['controller' => $settings['controller'], 'action' => 'add'], true);
        $settings['linkRefresh'] = Router::url(['controller' => $settings['controller'], 'action' => 'getAll', $settings['refreshParams']], true);

        $select =
            '<div class="input-group ' . (empty($settings['div']) ? '' : $settings['div']) . ' ' . $fieldName . '">' .
                parent::select($fieldName, $options, $attributes) .
                '<span class="input-group-btn">' .
                    '<a class="btn waves-effect waves-light refresh" data-href="' . $settings['linkRefresh'] . '" onclick="return refreshSelect(event.target || event.srcElement);">' . $this->materialIcon('autorenew') . '</a>' .
                    '<a class="btn waves-effect waves-light edit" href="' . $settings['linkEdit'] . '" onclick="return extendEdit(event);">' . $this->materialIcon('edit') . '</a>' .
                    '<a class="btn waves-effect waves-light add" href="' . $settings['linkAdd'] . '" onclick="return extendAdd(event);">' . $this->materialIcon('add') . '</a>' .
                '</span>' .
            '</div>';
	    return $select;
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

    public function getStatusOptions() {
	    return [
	        '' => 'Todos',
	        1 => 'Ativo',
            0 => 'Inativo'
        ];
    }
}
