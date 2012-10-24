<?php
namespace ERD\ValidationHelpers\Tests\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * Description of CollectionOfTest
 *
 * @author Ethan Resnick Design <hi@ethanresnick.com>
 * @copyright Jun 28, 2012 Ethan Resnick Design
 */
class CollectionOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \ERD\ValidationHelpers\Constraints\CollectionOf
     */
    protected $object;
    
    public function setUp()
    {
        $this->object = new \ERD\ValidationHelpers\Constraints\CollectionOf('stdClass');
    }

    public function testCollectionOfRequiresNameBeSet()
    {
        $this->assertContains('name', $this->object->getRequiredOptions());
    }
    
    public function testDefaultsAreCorrect()
    {
        $this->assertTrue($this->object->allowSubclasses);
        $this->assertTrue($this->object->allowNull);
    }
    
    public function testTargetIsAProperty()
    {
        $this->assertEquals(Constraint::PROPERTY_CONSTRAINT, $this->object->getTargets());
    }
    
    public function testNameIsDefaultOption()
    {
        $explicitName = new \ERD\ValidationHelpers\Constraints\CollectionOf(array('name'=>'stdClass'));
        $this->assertEquals($this->object->name, $explicitName->name);
    }
}