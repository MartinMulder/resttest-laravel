<?php

namespace RestTest\Laravel\Configuration\Validators;

use RestTest\Laravel\Configuration\ConfigurationException;

/**
 * Class ArrayValidator.
 *
 * Validates that the configuration value is an array.
 */
class ArrayValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        if (!is_array($this->value)) {
            throw new ConfigurationException("Option {$this->key} must be an array.");
        }

        return true;
    }
}