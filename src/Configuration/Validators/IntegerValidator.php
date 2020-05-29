<?php

namespace RestTest\Laravel\Configuration\Validators;

use RestTest\Laravel\Configuration\ConfigurationException;

/**
 * Class IntegerValidator.
 *
 * Validates that the configuration value is an integer / number.
 */
class IntegerValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        if (!is_numeric($this->value)) {
            throw new ConfigurationException("Option {$this->key} must be an integer.");
        }

        return true;
    }
}