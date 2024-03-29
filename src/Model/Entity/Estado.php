<?php
namespace App\Model\Entity;

use App\Model\Entity;
use Cake\ORM\TableRegistry;

/**
 * Estado Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $sigla
 * @property bool $status
 * @property int $pais_id
 *
 * @property \App\Model\Entity\Pais $pais
 * @property \App\Model\Entity\Cidade[] $cidades
 */
class Estado extends Entity
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
        'estado_pais'
    ];

    protected function _getEstadoPais() {
        $estados = TableRegistry::get('Estados');
        $pais = $estados->Paises->findById($this->pais_id)->first();
        if (!empty($pais)) {
            return $this->nome . ', ' . $pais->sigla;
        } else {
            return $this->nome;
        }
    }
}
