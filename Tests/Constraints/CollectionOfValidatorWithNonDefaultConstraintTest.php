<?php
namespace ERD\ValidationHelpers\Tests\Constraints;
use ERD\ValidationHelpers\Tests\Constraints\ChildStub;

/**
 * Description of CollectionOfValidatorWithNonDefaultConstraintTest
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jun 28, 2012 Ethan Resnick Design
 */
class CollectionOfValidatorWithNonDefaultConstraintTest
{
    /** @var \ERD\ValidationHelpers\Constraints\CollectionOfValidator */
    protected $validator;
    protected $constraint;

    public function setUp()
    {
       $this->validator  = new \ERD\ValidationHelpers\Constraints\CollectionOfValidator();
       $this->constraint = new \ERD\ValidationHelpers\Constraints\CollectionOf(array('name'=>'stdClass', 'allowNull'=>false, 'allowSubclasses'=>false));
    }    
    
    
    public function invalidCollectionsProvider()
    {
        return array(
            array(array(new ChildStub())),
            array(null),
            array(array(new \stdClass(), new ChildStub()))
        );
    }

    /**
     * @dataProvider invalidCollectionsProvider
     */
    public function testInvalidCollectionsMarkedInvalid($value)
    {
        $this->assertFalse($this->validator->isValid($value, $this->constraint));
    }
    
    public function testInvalidCollectionSetsProperConstraintMessage()
    {
        $invalidCollection = array(array());
        $this->validator->isValid($invalidCollection, $this->constraint);
        
        $this->assertTrue(in_array('stdClass', $this->validator->getMessageParameters()));
    }
    
    public function testAllowSubClassesDoesntPreventInterfaceImplementations()
    {
        $this->constraint->name = 'ERD\ValidationBundle\Test\Constraints\Test';
        $this->assertTrue($this->validator->isValid(array(array(new ChildStub())), $this->constraint));
    }
}