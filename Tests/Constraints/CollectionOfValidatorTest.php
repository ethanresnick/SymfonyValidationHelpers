<?php
namespace ERD\ValidationHelpers\Tests\Constraints;
use ERD\ValidationHelpers\Tests\Constraints\ChildStub;

/**
 * Description of CollectionOfValidatorTest
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 */
class CollectionOfValidatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var \ERD\ValidationHelpers\Constraints\CollectionOfValidator */
    protected $validator;
    protected $defaultConstraint;
    
    public function setUp()
    {
       $this->validator         = new \ERD\ValidationHelpers\Constraints\CollectionOfValidator();
       $this->defaultConstraint = new \ERD\ValidationHelpers\Constraints\CollectionOf(array('name'=>'stdClass'));
    }

    public function invalidCollectionsProvider()
    {
        return array(
            array(array(array(), array(), array())),
            array('as'),
            array(new \stdClass()),
            array(array(new \stdClass(), new CollectionOfTest()))
        );
    }
    
    public function validCollectionsProvider()
    {
        return array(
            array(array(new \stdClass())),
            array(array(new \stdClass(), new \stdClass())),
            array(array(new \stdClass(), new ChildStub())),
            array(null)
        );
    }
    
    /**
     * @dataProvider validCollectionsProvider
     */
    public function testValidCollectionsMarkedValid($value)
    {
        $this->assertTrue($this->validator->isValid($value, $this->defaultConstraint));
    }
    
    /**
     * @dataProvider invalidCollectionsProvider
     */
    public function testInvalidCollectionsMarkedInvalid($value)
    {
        $this->assertFalse($this->validator->isValid($value, $this->defaultConstraint));
    }
    
    public function testInvalidCollectionSetsProperConstraintMessage()
    {
        $invalidCollection = array(array());
        $this->validator->isValid($invalidCollection, $this->defaultConstraint);
        
        $this->assertTrue(in_array('stdClass', $this->validator->getMessageParameters()));
    }
}
?>