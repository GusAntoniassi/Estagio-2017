<?php
namespace Gus\Controller\Component;

use Cake\Controller\Component;

class GusComponent extends Component {
    public function getOptionsArray(\Cake\ORM\Query $query) {
        if (!is_array($query)) {
            $query = $query->toArray();
        }
        return ['' => 'Todos'] + $query;
    }

    public function getDiasSemanaArray() {
        return [
            '' => 'Não visita',
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];
    }
}