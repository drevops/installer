<?php

namespace DrevOps\Installer\Tests\Unit\Utils;

use DrevOps\Installer\Tests\Unit\UnitTestCase;
use DrevOps\Installer\Utils\Token;

/**
 * @coversDefaultClass \DrevOps\Installer\Utils\Token
 */
class TokenTest extends UnitTestCase {

  /**
   * @covers ::getConstants
   */
  public function testGetConstants(): void {
    $constants = Token::getConstants();

    $this->assertIsArray($constants);
    $this->assertContains(Token::COMMENTED_CODE, $constants);
  }

}
