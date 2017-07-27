<?php
namespace App\Model;

use Cake\ORM\Entity as BaseEntity;
use Cake\ORM\TableRegistry;

/**
 * Entity
 *
 * An entity represents a single result row from a repository. It exposes the
 * methods for retrieving and storing properties associated in this row.
 */
class Entity extends BaseEntity
{
    /**
     * Initialize the entity.
     *
     * @param array $properties hash of properties to set in this entity.
     * @param array $options list of options to use when creating this entity.
     */
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
    }

    /**
     * Get Display Field Virtual Property.
     *
     * Returns the value of the display field of this entity's underlying repository source.
     * @return null|mixed The value of the display field.
     */
    protected function _getDisplayField()
    {
        if ($this->_registryAlias === null) {
            return null;
        }

        $displayField = TableRegistry::get($this->_registryAlias)->getDisplayField();

        return $this->get($displayField);
    }

    /**
     * Get Primary Key Virtual Property.
     *
     * Returns the value of the primary key of this entity's underlying repository source.
     * @return null|mixed The value of the primary key.
     */
    protected function _getPrimaryKey()
    {
        if ($this->_registryAlias === null) {
            return null;
        }

        $primaryKey = TableRegistry::get($this->_registryAlias)->getPrimaryKey();

        return $this->get($primaryKey);
    }
}