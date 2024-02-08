<?php

namespace DrevOps\Installer\Utils;

/**
 * Executor.
 *
 * Execute commands.
 */
class Executor {

  /**
   * Execute command wrapper.
   *
   * @param string $command
   *   The command to execute.
   * @param array|null $output
   *   The output of the command.
   * @param null $return_var
   *   The return value of the command.
   *
   * @return false|string
   *   The output of the command.
   */
  public static function doExec(string $command, array &$output = NULL, &$return_var = NULL): string|false {
    return exec($command, $output, $return_var);
  }

  /**
   * Check if command exists.
   *
   * @param string $command
   *   The command to check.
   *
   * @throws \RuntimeException
   *   If the command does not exist.
   */
  public static function validateCommandExists(string $command): void {
    static::doExec('command -v ' . $command, $lines, $ret);
    if ($ret === 1) {
      throw new \RuntimeException(sprintf('Command "%s" does not exist in the current environment.', $command));
    }
  }

}
