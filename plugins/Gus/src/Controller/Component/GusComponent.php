<?php
namespace Gus\Controller\Component;

use Cake\Controller\Component;

class GusComponent extends Component {
    public function getOptionsArray(\Cake\ORM\Query $query) {
        if (!is_array($query)) {
            $query = $query->toArray();
        }
        return array_merge(['' => 'Todos'], $query);
    }
}