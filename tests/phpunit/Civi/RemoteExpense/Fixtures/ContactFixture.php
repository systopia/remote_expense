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

use Civi\Api4\Contact;

final class ContactFixture {

  /**
   * @param array<string, scalar> $values
   *
   * @return array
   * @phpstan-return array<string, scalar|null>&array{id: int}
   *
   * @throws \CRM_Core_Exception
   */
  public static function addIndividual(array $values = []): array {
    // @phpstan-ignore-next-line
    return Contact::create(FALSE)
      ->setValues($values + [
        'contact_type' => 'Individual',
        'first_name' => 'Some',
        'last_name' => 'Individual',
      ])->execute()->single();
  }

  /**
   * @param array<string, scalar> $values
   *
   * @return array
   * @phpstan-return array<string, scalar|null>&array{id: int}
   *
   * @throws \CRM_Core_Exception
   */
  public static function addOrganization(array $values = []): array {
    // @phpstan-ignore-next-line
    return Contact::create(FALSE)
      ->setValues($values + [
        'contact_type' => 'Organization',
        'legal_name' => 'Test organization',
      ])->execute()->single();
  }

}
