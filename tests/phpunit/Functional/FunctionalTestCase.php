<?php

namespace DrevOps\Installer\Tests\Functional;

use DrevOps\Installer\Tests\Traits\AssertTrait;
use DrevOps\Installer\Tests\Traits\EnvTrait;
use DrevOps\Installer\Tests\Traits\FixturesTrait;
use DrevOps\Installer\Utils\Env;
use PHPUnit\Framework\TestCase;
use DrevOps\Installer\Tests\Traits\VfsTrait;

abstract class FunctionalTestCase extends TestCase {

  use AssertTrait;
  use EnvTrait;
  use FixturesTrait;
  use VfsTrait;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    static::vfsSetRoot();
    static::fixturesPrepare();
  }

  protected function tearDown(): void {
    parent::tearDown();

    static::envReset();
  }

  /**
   * Disable the installation run.
   */
  protected function disableInstallRun() {
    static::envSet(Env::INSTALLER_INSTALL_PROCEED, 0);
  }

}
