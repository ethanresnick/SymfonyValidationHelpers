<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Validates the OptionalDateTime Constraint
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jan 8, 2012 Ethan Resnick Design
 */
class OptionalDateTimeValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        if($value instanceof \DateTime || $value===null)
        {
            return true;
        }
        
        else
        {
            $this->setMessage($constraint->message);
            return false;
        }
    }
}