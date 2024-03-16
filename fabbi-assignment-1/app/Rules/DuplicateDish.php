<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DuplicateDish implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function isNotDuplicateDish(...$arrays) {
        $uniqueElements = [];
        foreach ($arrays as $array) {
            foreach ($array as $element) {
                if (in_array($element['dish'], $uniqueElements)) {
                    return false;
                }
                $uniqueElements[] = $element['dish'];
            }
        }
    
        return true;
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
        return $this->isNotDuplicateDish($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Please don't select one dish twice.";
    }
}
