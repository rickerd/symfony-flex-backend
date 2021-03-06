<?php
declare(strict_types=1);
/**
 * /tests/Integration/Form/DataTransformer/RoleTransformerTest.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Tests\Integration\Form\DataTransformer;

use App\Entity\Role;
use App\Form\DataTransformer\RoleTransformer;
use App\Resource\RoleResource;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class RoleTransformerTest
 *
 * @package App\Tests\Integration\Form\Console\DataTransformer
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
class RoleTransformerTest extends KernelTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|RoleResource
     */
    private $roleResource;

    /**
     * @dataProvider dataProviderTestThatTransformReturnsExpected
     *
     * @param mixed $expected
     * @param mixed $input
     */
    public function testThatTransformReturnsExpected($expected, $input): void
    {
        $transformer = new RoleTransformer($this->roleResource);

        static::assertSame($expected, $transformer->transform($input));
    }

    public function testThatReverseTransformCallsExpectedObjectManagerMethods(): void
    {
        $entity = new Role();

        $this->roleResource
            ->expects(static::once())
            ->method('findOne')
            ->with('rolename')
            ->willReturn($entity);

        $transformer = new RoleTransformer($this->roleResource);
        $transformer->reverseTransform('rolename');

        unset($transformer, $entity);
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Role with name "rolename" does not exist!
     */
    public function testThatReverseTransformThrowsAnException(): void
    {
        $this->roleResource
            ->expects(static::once())
            ->method('findOne')
            ->with('rolename')
            ->willReturn(null);

        $transformer = new RoleTransformer($this->roleResource);
        $transformer->reverseTransform('rolename');

        unset($transformer);
    }

    public function testThatReverseTransformReturnsExpected(): void
    {
        $entity = new Role();

        $this->roleResource
            ->expects(static::once())
            ->method('findOne')
            ->with('rolename')
            ->willReturn($entity);

        $transformer = new RoleTransformer($this->roleResource);

        static::assertSame($entity, $transformer->reverseTransform('rolename'));

        unset($transformer, $entity);
    }

    /**
     * @return array
     */
    public function dataProviderTestThatTransformReturnsExpected(): array
    {
        $entity = new Role();

        return [
            ['', null],
            [$entity->getId(), $entity],
        ];
    }

    protected function setUp(): void
    {
        gc_enable();

        parent::setUp();

        $this->roleResource = $this
            ->getMockBuilder(RoleResource::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->roleResource);

        gc_collect_cycles();
    }
}
