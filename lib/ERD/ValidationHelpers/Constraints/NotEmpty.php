<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * Checks if an array/collection (i.e. something implementing the Array-like SPL interfaces) is empty.
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jan 8, 2012 Ethan Resnick Design
 * @Annotation
 */
class NotEmpty extends Constraint
{
    public $message = 'This array/collection must not be empty.';
}