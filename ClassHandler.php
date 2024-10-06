<?php

/*
 * This file is part of MythicalSystemsFramework.
 * Please view the LICENSE file that was distributed with this source code.
 *
 * (c) MythicalSystems <mythicalsystems.xyz> - All rights reserved
 * (c) NaysKutzu <nayskutzu.xyz> - All rights reserved
 * (c) Cassian Gherman <nayskutzu.xyz> - All rights reserved
 *
 * You should have received a copy of the MIT License
 * along with this program. If not, see <https://opensource.org/licenses/MIT>.
 */

use MythicalSystemsFramework\Cli\Kernel;
use MythicalSystemsFramework\Backup\Backup;
use MythicalSystemsFramework\Kernel\Logger;
use MythicalSystemsFramework\Database\MySQL;
use MythicalSystemsFramework\Kernel\LoggerTypes;
use MythicalSystemsFramework\Kernel\LoggerLevels;

class ClassHandler
{
    public const TABLE_NAME = 'framework_addon_testing_data';
    public static $columns = [
        'id',
        'last_backup',
    ];

    /**
     * Create the table if it doesn't exist.
     *
     * @return void
     */
    public static function createTableIfNotExist()
    {
        $mysql = new MySQL();
        $conn = $mysql->connectMYSQLI();
        $conn->query('CREATE TABLE IF NOT EXISTS `' . self::TABLE_NAME . '` (`id` INT NOT NULL AUTO_INCREMENT , `last_backup` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;');
        self::updateLastBackup();
    }

    /**
     * Drop the table.
     *
     * @return void
     */
    public static function dropTable()
    {
        $mysql = new MySQL();
        $conn = $mysql->connectMYSQLI();
        $conn->query('DROP TABLE IF EXISTS ' . self::TABLE_NAME . '');
    }

    /**
     * Update the last backup date.
     *
     * @return void
     */
    public static function updateLastBackup()
    {
        $mysql = new MySQL();
        $conn = $mysql->connectMYSQLI();
        $conn->query('UPDATE `' . self::TABLE_NAME . '` SET `' . self::$columns[1] . '` = CURRENT_TIMESTAMP WHERE `' . self::$columns[0] . '` = 1');
    }
}
