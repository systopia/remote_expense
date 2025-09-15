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

namespace Civi\RemoteExpense\Fixtures;

use Civi\Api4\CiviExpense;

final class ExpenseFixture {

  /**
   * @phpstan-param array<string, scalar|null> $values
   *
   * @phpstan-return array{id: int}&array<string, scalar|null>
   *
   * @throws \CRM_Core_Exception
   */
  public static function addFixture(int $contactId, int $caseId, array $values = []): array {
    // @phpstan-ignore-next-line
    return CiviExpense::create(FALSE)->setValues([
      'type_id' => 1,
      'contact_id' => $contactId,
      'case_id' => $caseId,
    ] + $values)->execute()->single();
  }

}
