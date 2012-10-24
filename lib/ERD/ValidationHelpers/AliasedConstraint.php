<?php
namespace ERD\ValidationHelpers;

/**
 * Extends the default constraint class to allow properties to be set with an aliased option name
 * (i.e. rather than forcing the name of the option to match the name of the property exactly).
 * 
 * This can allow for neater/shorter constraint configuration files/annotations.
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jun 28, 2012 Ethan Resnick Design
 */
abstract class AliasedConstraint extends \Symfony\Component\Validator\Constraint
{
    /**
     * @var array All the aliases your constraint uses, in the form aliasName=>fullPropertyName
     */
    public $aliases = array();

    public function __construct($options = null)
    {
        if(is_array($options))
        {
            $options = $this->aliasOptions($options);
        }
        
        parent::__construct($options);
    }
    
    protected function aliasOptions($options)
    {
        foreach($this->aliases as $alias=>$fullName)
        {        
            if(array_key_exists($alias, $options))
            {
                $options[$fullName] = $options[$alias];
                unset($options[$alias]);
            }
        }

        return $options;
    }
}