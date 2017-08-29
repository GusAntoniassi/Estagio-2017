<?php
namespace App\Model\Entity;

use App\Model\Entity;
use Cake\ORM\TableRegistry;

/**
 * Cidade Entity
 *
 * @property int $id
 * @property string $nome
 * @property bool $status
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Estado $estado
 * @property \App\Model\Entity\Pessoa[] $pessoas
 */
class Cidade extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected $_virtual = [
        'cidade_estado'
    ];

    protected function _getCidadeEstado() {
        $cidades = TableRegistry::get('Cidades');
        $estado = $cidades->Estados->findById($this->estado_id)->first();
        if (!empty($estado)) {
            return $this->nome . ', ' . $estado->sigla;
        } else {
            return $this->nome;
        }
    }
}
