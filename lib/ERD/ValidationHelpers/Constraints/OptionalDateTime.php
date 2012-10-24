<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * A validator that allows a field to be a DateTime or null.
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jan 8, 2012 Ethan Resnick Design
 * @Annotation
 */
class OptionalDateTime extends Constraint
{
    public $message = 'This value is not valid. It must be a DateTime object or null.';
}