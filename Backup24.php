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
    public function Main(): void
    {
        // DO nothing since you don't need to do something :)
    }

    public function Event(MythicalSystemsFramework\Plugins\PluginEvent $eventHandler): void
    {
        require __DIR__ . '/ClassHandler.php';

        // Load routes
        $eventHandler->on('app.onAppLoad', function ($router, $renderer) {
            /**
             * Routes for the Backup24 plugin.
             */
            $router->add('/addons/backup24/info', function () {
                global $renderer;

                exit(ClassHandler::getLastBackup() . ' | ' . ClassHandler::getCurrentSystemTime() . ' | Is it time for backup? ' . ClassHandler::isTimeForBackup());
            });
        });
    }

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
