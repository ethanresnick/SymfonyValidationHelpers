<?php
namespace ERD\ValidationHelpers\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * Used to validate whether a value is a collection (i.e. array or some \Traversable object) of
 * objects of a given class or interface.
 *
 * @Annotation
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jun 28, 2012 Ethan Resnick Design
 */
class CollectionOf extends Constraint
{
    public $message   = 'This propery must hold an array (or \Traversable collection) of {{ class }} instances.';
    
    /**
     * @var string The name of the class/interface that all objects in the collection must be an instance of.
     *
     * Note that this string, in order to keep the assertion more concise, isn't namespace-dependent. So you can just
     * enter "Subject" as your name, it'll allow classes called "Subject" in any namespace. But if you don't want that,
     * simply include the namespace, e.g. "MyNamespace\Subject" or, for only Subject in the global namespace, "\Subject".
     */
    public $name;
    
    /** 
     * @var boolean If false, sub classes of {@link $name} won't be accepted, whereas they otherwise
     *              would have been. Instead, only objects whose class matches exactly will be allowed.
     */
    public $allowSubclasses = true;

    /** @var boolean Whether to allow NULL as a valid value (e.g. like an alternative to an empty collection) */
    public $allowNull = true;


    public function getDefaultOption()
    {
        return 'name';
    }

    public function getRequiredOptions()
    {
        return array('name');
    }
}