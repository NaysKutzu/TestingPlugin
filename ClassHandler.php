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
    public const TABLE_NAME = 'framework_addon_backup24_data';
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

    /**
     * Get the last backup date.
     */
    public static function getLastBackup(): string
    {
        $mysql = new MySQL();
        $conn = $mysql->connectMYSQLI();
        $result = $conn->query('SELECT `' . self::$columns[1] . '` FROM ' . self::TABLE_NAME . ' WHERE `id` = ' . self::$columns[0] . '');
        $row = $result->fetch_assoc();
        if (empty($row)) {
            self::updateLastBackup();
        }

        return $row['last_backup'];
    }

    /**
     * Get the current system time.
     */
    public static function getCurrentSystemTime(): string
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Check if it's time for a backup.
     */
    public static function isTimeForBackup(): bool
    {
        $lastBackup = self::getLastBackup();
        $nowTime = self::getCurrentSystemTime();
        $lastBackupTime = strtotime($lastBackup);
        $currentTime = strtotime($nowTime);
        if (($currentTime - $lastBackupTime) >= 86400) {
            return true;
        }
        return false;
    }

    /**
     * Take a backup.
     */
    public static function takeBackup(): void
    {
        if (self::isTimeForBackup()) {
            self::updateLastBackup();
            Backup::setBackupStatus(Backup::take(), MythicalSystemsFramework\Backup\Status::DONE);
            Logger::log(LoggerLevels::INFO, LoggerTypes::BACKUP, '[Backup 24] Backup taken successfully');
            echo Kernel::translateColorsCode('&a[Backup 24] &7Backup taken successfully.');
        } else {
            echo Kernel::translateColorsCode("&c[Backup 24] &7Backup not taken, it's not time yet.");
        }
    }
}
