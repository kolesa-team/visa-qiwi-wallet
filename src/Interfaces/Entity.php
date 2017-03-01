<?php
namespace Qiwi\Interfaces;

/**
 * Entity interface
 */
interface Entity
{
    /**
     * Returns array representation of entity
     *
     * @return array
     */
    public function toArray();

    /**
     * Constructs entity from array
     *
     * @param  array                   $input
     * @return \Qiwi\Interfaces\Entity
     */
    public static function fromArray(array $input);
}
