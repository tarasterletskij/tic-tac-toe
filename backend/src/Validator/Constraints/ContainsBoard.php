<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsBoard extends Constraint
{
    public $message = "The board '{{ string }}' can be with the next symbols: 'X', 'O', '-' and size should be always with 9 letters";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
