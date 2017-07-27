<?php
namespace App\Model\Entity;

use App\Model\Entity;;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $login
 * @property string $senha
 * @property string $salt
 * @property bool $status
 * @property int $grupo_usuario_id
 *
 * @property \App\Model\Entity\GrupoUsuario $grupo_usuario
 */
class Usuario extends Entity
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
}
