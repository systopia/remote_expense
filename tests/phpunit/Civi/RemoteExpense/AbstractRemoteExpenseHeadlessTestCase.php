<?php
/*
 * Copyright (C) 2024 SYSTOPIA GmbH
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation in version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\RemoteExpense;

use Civi\RemoteExpense\Api4\Permissions;
use Civi\Test;
use Civi\Test\CiviEnvBuilder;
use Civi\Test\HeadlessInterface;
use Civi\Test\TransactionalInterface;
use PHPUnit\Framework\TestCase;

// phpcs:disable Generic.Files.LineLength.TooLong
abstract class AbstractRemoteExpenseHeadlessTestCase extends TestCase implements HeadlessInterface, TransactionalInterface {
// phpcs:enable
  public function setUpHeadless(): CiviEnvBuilder {
    return Test::headless()
      ->install('expense')
      ->install('de.systopia.identitytracker')
      ->install('de.systopia.remotetools')
      ->installMe(__DIR__)
      ->apply();
  }

  protected function setUp(): void {
    parent::setUp();
    \CRM_Core_Config::singleton()->userFrameworkBaseURL = 'http://localhost/';
    \CRM_Core_Config::singleton()->cleanURL = 1;
    $this->setUserPermissions([Permissions::ACCESS_REMOTE_EXPENSE]);
  }

  /**
   * @phpstan-param array<string>|null $permissions
   */
  protected function setUserPermissions(?array $permissions): void {
    $userPermissions = \CRM_Core_Config::singleton()->userPermissionClass;
    if (NULL !== $permissions) {
      $userPermissions->permissions = $permissions;
    }
  }

}
