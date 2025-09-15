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

namespace Civi\Api4;

use Civi\API\Exception\UnauthorizedException;
use Civi\RemoteExpense\AbstractRemoteExpenseHeadlessTestCase;
use Civi\RemoteExpense\Fixtures\CaseFixture;
use Civi\RemoteExpense\Fixtures\ContactFixture;
use Civi\RemoteExpense\Fixtures\ExpenseFixture;

/**
 * @covers \Civi\Api4\RemoteExpense
 * @covers \Civi\RemoteExpense\RemoteExpenseTestEntityProfile
 *
 * @group headless
 */
class RemoteExpenseTest extends AbstractRemoteExpenseHeadlessTestCase {

  public function testDelete(): void {
    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $expense = ExpenseFixture::addFixture($contact['id'], $case['id']);

    $result = RemoteExpense::delete()
      ->setProfile('test')
      ->addWhere('id', '=', $expense['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGet(): void {
    $result = RemoteExpense::get()
      ->setProfile('test')
      ->execute();

    static::assertCount(0, $result);

    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $expense = ExpenseFixture::addFixture($contact['id'], $case['id']);

    $result = RemoteExpense::get()
      ->setProfile('test')
      ->addSelect('*', 'CAN_delete', 'CAN_update')
      ->execute();

    static::assertCount(1, $result);
    static::assertSame($expense['id'], $result->single()['id']);
    static::assertSame($expense['type_id'], $result->single()['type_id']);
    static::assertSame($expense['contact_id'], $result->single()['contact_id']);
    static::assertSame($expense['case_id'], $result->single()['case_id']);
    static::assertFalse($result->single()['CAN_delete']);
    static::assertFalse($result->single()['CAN_update']);

    $result = RemoteExpense::get()
      ->setProfile('test')
      ->addWhere('id', '!=', $expense['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGetActions(): void {
    $result = RemoteExpense::getActions()->execute();
    $actions = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('get', $actions);
  }

  public function testGetCreateForm(): void {
    $this->expectException(UnauthorizedException::class);
    RemoteExpense::getCreateForm()
      ->setProfile('test')
      ->execute();
  }

  public function testGetFields(): void {
    $result = RemoteExpense::getFields()
      ->setProfile('test')
      ->addSelect('*', 'CAN_delete', 'CAN_update')
      ->execute();

    $fields = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('type_id', $fields);
    static::assertArrayHasKey('contact_id', $fields);
    static::assertArrayHasKey('case_id', $fields);
    static::assertArrayHasKey('CAN_delete', $fields);
    static::assertArrayHasKey('CAN_update', $fields);
  }

  public function testGetUpdateForm(): void {
    $contact = ContactFixture::addIndividual();
    $case = CaseFixture::addFixture($contact['id']);
    $expense = ExpenseFixture::addFixture($contact['id'], $case['id']);

    $this->expectException(UnauthorizedException::class);
    RemoteExpense::getUpdateForm()
      ->setProfile('test')
      ->setId((int)$expense['id'])
      ->execute();
  }

}
