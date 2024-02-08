<?php

namespace DrevOps\Installer\Tests\Unit\Utils;

use DrevOps\Installer\Tests\Unit\UnitTestCase;
use DrevOps\Installer\Utils\DotEnv;

/**
 * Class InstallerDotEnvTest.
 *
 * InstallerDotEnvTest fixture class.
 *
 * phpcs:disable Drupal.Commenting.FunctionComment.Missing
 * phpcs:disable Drupal.Commenting.DocComment.MissingShort
 */
class DotEnvTest extends UnitTestCase {

  /**
   * Backup value of the $GLOBALS['_SERVER'] variable.
   *
   * @var array
   */
  protected $backupServer;

  /**
   * Backup value of the $GLOBALS['_ENV'] variable.
   *
   * @var array
   */
  protected $backupEnv;

  protected function setUp(): void {
    $this->backupEnv = $GLOBALS['_ENV'];
    $this->backupServer = $GLOBALS['_SERVER'];

    parent::setUp();
  }

  protected function tearDown(): void {
    $GLOBALS['_ENV'] = $this->backupEnv;
    $GLOBALS['_SERVER'] = $this->backupServer;
  }

  /**
   * @covers \DrevOps\Installer\Utils\DotEnv::loadDotenv
   * @runInSeparateProcess
   */
  public function testLoadDotEnv(): void {
    $content = 'var1=val1';
    $filename = $this->createFixtureEnvFile($content);

    $this->assertEmpty(getenv('var1'));
    $this->callProtectedMethod(DotEnv::class, 'loadDotenv', [$filename]);
    $this->assertEquals('val1', getenv('var1'));

    // Try overloading with the same value - should not allow.
    $content = 'var1=val11';
    $filename = $this->createFixtureEnvFile($content);
    $this->callProtectedMethod(DotEnv::class, 'loadDotenv', [$filename]);
    $this->assertEquals('val1', getenv('var1'));

    // Force overriding of existing variables.
    $content = 'var1=val11';
    $filename = $this->createFixtureEnvFile($content);
    $this->callProtectedMethod(DotEnv::class, 'loadDotenv', [$filename]);
    // @todo Fix this test.
    // $this->assertEquals('val11', getenv('var1'));
  }

  /**
   * @covers       \DrevOps\Installer\Utils\DotEnv::loadDotenv
   * @dataProvider dataProviderGlobals
   * @runInSeparateProcess
   */
  public function testGlobals(string $content, array $env_before, array $server_before, array $env_after, mixed $server_after, bool $allow_override): void {
    $filename = empty($content) ? 'randomfilename' : $this->createFixtureEnvFile($content);

    $GLOBALS['_ENV'] = $env_before;
    $GLOBALS['_SERVER'] = $server_before;

    $this->callProtectedMethod(DotEnv::class, 'loadDotenv', [$filename]);

    // @todo Fix this test.
    // $this->assertEquals($GLOBALS['_ENV'], $env_after);
    $this->assertEquals($GLOBALS['_SERVER'], $server_after);

    $this->assertTrue(TRUE);
  }

  public static function dataProviderGlobals(): array {
    return [
      [
        '', [], [], [], [], FALSE,
      ],
      [
        '', ['var1' => 'val1'], ['var2' => 'val2'], ['var1' => 'val1'], ['var2' => 'val2'], FALSE,
      ],
      // Simple value.
      [
        'var3=val3',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3'],
        ['var2' => 'val2', 'var3' => 'val3'],
        FALSE,
      ],
      // Multiple values.
      [
        '
        var3=val3
        var4=val4
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3', 'var4' => 'val4'],
        ['var2' => 'val2', 'var3' => 'val3', 'var4' => 'val4'],
        FALSE,
      ],
      // Empty value.
      [
        'var3=',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => ''],
        ['var2' => 'val2', 'var3' => ''],
        FALSE,
      ],
      [
        'var3=""',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => ''],
        ['var2' => 'val2', 'var3' => ''],
        FALSE,
      ],
      // Preserve existing values.
      [
        '
        var1=val11
        var4=val4
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var4' => 'val4'],
        ['var2' => 'val2', 'var1' => 'val11', 'var4' => 'val4'],
        FALSE,
      ],
      // Override existing values.
      [
        '
        var1=val11
        var4=val4
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val11', 'var4' => 'val4'],
        ['var2' => 'val2', 'var1' => 'val11', 'var4' => 'val4'],
        TRUE,
      ],
      // Comments.
      [
        '
        var3=val3
        # var4=val4
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3'],
        ['var2' => 'val2', 'var3' => 'val3'],
        FALSE,
      ],
      [
        '
        var3=val3
        var4=val4 # inline comment
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3', 'var4' => 'val4'],
        ['var2' => 'val2', 'var3' => 'val3', 'var4' => 'val4'],
        FALSE,
      ],
      [
        '
        var3=val3
        var4="val4 # inside"
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3', 'var4' => 'val4 # inside'],
        ['var2' => 'val2', 'var3' => 'val3', 'var4' => 'val4 # inside'],
        FALSE,
      ],
      [
        '
        var3=val3
        #var4="val4 # inside"
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3'],
        ['var2' => 'val2', 'var3' => 'val3'],
        FALSE,
      ],
      [
        '
        var3=val3
        var4="val4 # inside" # inline comment after code
        ',
        ['var1' => 'val1'],
        ['var2' => 'val2'],
        ['var1' => 'val1', 'var3' => 'val3', 'var4' => 'val4 # inside'],
        ['var2' => 'val2', 'var3' => 'val3', 'var4' => 'val4 # inside'],
        FALSE,
      ],
    ];
  }

  protected function createFixtureEnvFile($content): string|false {
    $filename = tempnam(sys_get_temp_dir(), '.env');
    file_put_contents($filename, $content);

    return $filename;
  }

}
