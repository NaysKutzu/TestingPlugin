<?php
use MythicalSystemsFramework\Kernel\Logger;
use MythicalSystemsFramework\Kernel\LoggerTypes;
use MythicalSystemsFramework\Kernel\LoggerLevels;
use MythicalSystemsFramework\Plugins\PluginBuilder;

class Backup24 implements PluginBuilder
{
    public function Main(): void
    {
        // TODO: Implement the main function
    }

    public function Event(MythicalSystemsFramework\Plugins\PluginEvent $eventHandler): void
    {
    }

    public function onInstall(): void
    {
        Logger::log(LoggerLevels::INFO, LoggerTypes::PLUGIN, 'Backup24 plugin installed');
    }

    public function onUninstall(): void
    {
        Logger::log(LoggerLevels::INFO, LoggerTypes::PLUGIN, 'Backup24 plugin uninstalled');
    }
}
