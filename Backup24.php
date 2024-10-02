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

use MythicalSystemsFramework\Kernel\Logger;
use MythicalSystemsFramework\Kernel\LoggerTypes;
use MythicalSystemsFramework\Kernel\LoggerLevels;
use MythicalSystemsFramework\Plugins\PluginBuilder;

class Backup24 implements PluginBuilder
{
    public function Main(): void {}
    public function Event(MythicalSystemsFramework\Plugins\PluginEvent $eventHandler): void {}
    public function onInstall(): void
    {
        require __DIR__ . '/ClassHandler.php';
        ClassHandler::createTableIfNotExist();
        Logger::log(LoggerLevels::INFO, LoggerTypes::PLUGIN, 'Backup24 plugin installed');
    }

    public function onUninstall(): void
    {
        require __DIR__ . '/ClassHandler.php';
        ClassHandler::dropTable();
        Logger::log(LoggerLevels::INFO, LoggerTypes::PLUGIN, 'Backup24 plugin uninstalled');
    }
}
