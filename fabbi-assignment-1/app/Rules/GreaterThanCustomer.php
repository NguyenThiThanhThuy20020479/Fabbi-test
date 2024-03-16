<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterThanCustomer implements Rule
{
    protected $customers;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $re = 0;
        foreach ($value as $v) {
            $re += (int)$v;
        }

        return $re >= $this->customers && $re <= 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The maximum of number servings is 10 and total servings is greater than customers.';
    }
}
