<?php

namespace DrevOps\Installer\Utils;

/**
 * Output utilities.
 *
 * Helper functions for working with Output.
 */
class Output {

  final const STATUS_DEBUG = 'DEBUG';

  final const STATUS_MESSAGE = 'INFO';

  final const STATUS_SUCCESS = '  OK  ';

  /**
   * Output a status message.
   *
   * @param string $message
   *   The message.
   * @param string $type
   *   The type of message.
   * @param bool $newline
   *   Whether to add a newline.
   */
  public static function status(string $message, string $type = Output:: STATUS_MESSAGE, bool $newline = TRUE): void {
    // @todo Implement Output::status() method.
    print '[' . $type . '] ' . $message . ($newline ? PHP_EOL : '');
  }

}
