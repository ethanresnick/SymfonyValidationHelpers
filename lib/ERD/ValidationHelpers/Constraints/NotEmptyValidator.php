<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Validates the NotEmpty Constraint
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jan 8, 2012 Ethan Resnick Design
 */
class NotEmptyValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        $return = ((is_array($value) || $value instanceof \Countable) && count($value)>0);
        
        if($return===false)
        {
            $this->setMessage($constraint->message);
        }
        
        return $return;
    }
}