<?php

declare(strict_types=1);

namespace Qiwi\Interfaces;

/**
 * Entity interface
 */
interface Entity
{
    /**
     * Returns array representation of entity
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Constructs entity from array
     *
     * @param array<string, mixed> $input
     */
    public static function fromArray(array $input): Entity;
}
