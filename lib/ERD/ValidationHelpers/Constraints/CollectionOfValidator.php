<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Description of CollectionOfValidator
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jun 28, 2012 Ethan Resnick Design
 */
class CollectionOfValidator extends ConstraintValidator
{
    protected $constraint;
    protected $matchInNamespace;
    protected $nameToMatch;

    public function isValid($collection, Constraint $constraint)
    {
        //invalid constraint (no class to check against)
        if(!$constraint->name) {
            throw new MissingOptionsException('The constraint must have a (non-empty) name', array('name'));
        }

        //null value to validate
        if($collection === null) { return (boolean) $constraint->allowNull; }

        //not a null value, but it's not traversable
        if(!is_array($collection) && !($collection instanceof \Traversable)) { return false; }

        //everything's set up right, so set some variables in preparation for the validation.
        $this->constraint = $constraint;
        $this->matchInNamespace = (strpos($constraint->name, '\\')!==FALSE);
        $this->nameToMatch = (strpos($constraint->name, '\\')===0) ? substr($constraint->name, 1) : $constraint->name;

        //do the validation
        foreach($collection as $item) {
            if(!$this->isValidItem($item)) {
                $this->setMessage($constraint->message, array('{{ class }}'=>$constraint->name));
                return false;
            }
        }

        return true;
    }

    private function isValidItem($obj)
    {
        if(!is_object($obj)) {
            return false;
        }

        //If we're matching against a namespace, we need to find the FQCNs for each interface, parent, etc.
        //But if we're not, we just need to find the class name component for each interface/parent, independent of its namespace.
        if($this->matchInNamespace) {
            $objInterfaces    = class_implements($obj);
            $objClassName     = get_class($obj);
            $objParentClasses = class_parents($obj);
        }
        else {
            $namespaceStripper = function($fqcn) {return join('', array_slice(explode('\\', $fqcn), -1)); };

            $objInterfaces    = array_map($namespaceStripper, class_implements($obj));
            $objClassName     = array_map($namespaceStripper, get_class($obj));
            $objParentClasses = array_map($namespaceStripper, class_parents($obj));
        }

        $matchesOnClassOrInterface = ($objClassName==$this->nameToMatch || in_array($this->nameToMatch, $objInterfaces));

        if(!$this->constraint->allowSubclasses) {
            return $matchesOnClassOrInterface;
        }
        else {
            return ($matchesOnClassOrInterface || in_array($this->nameToMatch, $objParentClasses));
        }
    }
}