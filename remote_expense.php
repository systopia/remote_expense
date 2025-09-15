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

// phpcs:disable PSR1.Files.SideEffects
require_once 'remote_expense.civix.php';
// phpcs:enable

use Civi\RemoteCase\Api4\Permissions;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use CRM_RemoteExpense_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function remote_expense_civicrm_config(\CRM_Core_Config $config): void {
  _remote_expense_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_container().
 */
function remote_case_civicrm_container(ContainerBuilder $container): void {
  if (function_exists('_remote_expense_test_civicrm_container')) {
    _remote_expense_test_civicrm_container($container);
  }
}

/**
 * Implements hook_civicrm_permission().
 *
 * @phpstan-param array<string, string|array{string, string}> $permissions
 */
function remote_case_civicrm_permission(array &$permissions): void {
  $permissions[Permissions::ACCESS_REMOTE_EXPENSE] = [
    'label' => E::ts('CiviRemote: remote access to Expense'),
    'description' => E::ts('Access remote API of the Expense entity'),
  ];
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function remote_expense_civicrm_install(): void {
  _remote_expense_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function remote_expense_civicrm_enable(): void {
  _remote_expense_civix_civicrm_enable();
}
