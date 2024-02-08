<?php

namespace DrevOps\Installer\Tests\Functional\Application;

use DrevOps\Installer\Tests\Functional\ApplicationTestCase;

class OptionsApplicationTest extends ApplicationTestCase {

  /**
   * Test the execute method.
   *
   * @covers \DrevOps\Installer\InstallerApp::__construct
   * @covers \DrevOps\Installer\Command\InstallCommand::configure
   * @covers \DrevOps\Installer\Command\InstallCommand::initIo
   * @dataProvider dataProviderExecuteOptions
   * @runInSeparateProcess
   */
  public function testExecuteOptions(array $input, string $expected): void {
    $this->disableInstallRun();
    $this->assertStringContainsString($expected, $this->execute($input));
  }

  public static function dataProviderExecuteOptions(): array {
    return [
      [['--help' => TRUE], 'Destination directory. Optional. Defaults to the current directory'],
      [['--version' => TRUE], 'DrevOps CLI Installer @git-version@'],
    ];
  }

}
