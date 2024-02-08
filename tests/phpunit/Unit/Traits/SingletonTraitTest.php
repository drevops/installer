<?php

namespace DrevOps\Installer\Tests\Unit\Traits;

use DrevOps\Installer\Tests\Unit\UnitTestCase;
use DrevOps\Installer\Trait\SingletonTrait;

/**
 * @coversDefaultClass \DrevOps\Installer\Trait\SingletonTrait
 * @runClassInSeparateProcess
 */
class SingletonTraitTest extends UnitTestCase {

  /**
   * @covers ::__construct
   * @convertErrorsToExceptions
   */
  public function testConstructor(): void {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Cannot instantiate Singleton class directly. Use ::getInstance() instead.');
    (new TestSingleton());
  }

  /**
   * @covers ::getInstance
   */
  public function testSingletonInstance(): void {
    $first = TestSingleton::getInstance();
    $second = TestSingleton::getInstance();

    $this->assertSame($first, $second, 'Both instances should be the same');
  }

  /**
   * @covers ::__clone
   */
  public function testCloneIsDisabled(): never {
    $instance = TestSingleton::getInstance();
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Cloning of Singleton is disallowed.');
    $instance2 = clone $instance;
    throw new \RuntimeException('This line should not be reached.');
  }

  /**
   * @covers ::__wakeup
   */
  public function testUnserializeIsDisabled(): never {
    $instance = TestSingleton::getInstance();

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Unserializing instances of Singleton classes is disallowed.');

    $serialized = serialize($instance);
    unserialize($serialized);

    throw new \RuntimeException('This line should not be reached.');
  }

}


class TestSingleton {

  use SingletonTrait;

}
