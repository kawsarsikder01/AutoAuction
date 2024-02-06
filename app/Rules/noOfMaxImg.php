<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class noOfMaxImg implements ValidationRule
{
    protected $numberOfRequestImage;
    public function __construct($noImg = 0)
    {
        $this->numberOfRequestImage = $noImg;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user =  Auth::user();

        $noMaximumImage = $user->plan->first()->noOfMaxImg;
        if($noMaximumImage < $this->numberOfRequestImage){

            $fail("You can not upload more than $noMaximumImage image");
        }
    }
}
