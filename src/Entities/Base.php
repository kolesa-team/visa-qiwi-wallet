<?php

declare(strict_types=1);

namespace Qiwi\Entities;

use Qiwi\Exceptions\Validation\EmptyParameter;
use Qiwi\Exceptions\Validation\InvalidFormat;

/**
 * Base entity class
 */
abstract class Base
{
    /**
     * Mandatory fields for post-validation.
     *
     * @var string[]
     */
    protected array $mandatoryFields = [];

    /**
     * Validates value against format pattern
     *
     * @throws \Qiwi\Exceptions\Validation\InvalidFormat
     */
    protected function preValidate(mixed $format, mixed $value): void
    {
        if (!is_string($value) || !is_string($format)) {
            throw new InvalidFormat('Only string arguments allowed');
        }

        if (!preg_match($format, $value)) {
            throw new InvalidFormat(sprintf('Value "%s" does not match format "%s"', $value, $format));
        }
    }

    /**
     * Validates resulting array against mandatory fields existence.
     *
     * @param  array<string, mixed>                       $data
     * @throws \Qiwi\Exceptions\Validation\EmptyParameter
     */
    protected function postValidate(array $data): void
    {
        foreach ($this->mandatoryFields as $mandatoryField) {
            if (!isset($data[$mandatoryField]) || (empty($data[$mandatoryField]) && $data[$mandatoryField] !== '0')) {
                throw new EmptyParameter(sprintf('Field "%s" is mandatory and not set', $mandatoryField));
            }
        }
    }
}
