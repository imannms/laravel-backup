<?php

namespace Imannms\Backup;

use Illuminate\Support\ServiceProvider;
use Imannms\Backup\Commands\ListCommand;
use Imannms\Backup\Helpers\ConsoleOutput;
use Imannms\Backup\Commands\BackupCommand;
use Imannms\Backup\Commands\CleanupCommand;
use Imannms\Backup\Commands\MonitorCommand;
use Imannms\Backup\Notifications\EventHandler;
use Imannms\Backup\Tasks\Cleanup\CleanupStrategy;
use Imannms\Backup\Tasks\Cleanup\Strategies\DefaultStrategy;

class BackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/backup.php' => config_path('backup.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/backup'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'backup');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/backup.php', 'backup');

        $this->app['events']->subscribe(EventHandler::class);

        $this->app->bind('command.backup:run', BackupCommand::class);
        $this->app->bind('command.backup:clean', CleanupCommand::class);
        $this->app->bind('command.backup:list', ListCommand::class);
        $this->app->bind('command.backup:monitor', MonitorCommand::class);

        $this->app->bind(CleanupStrategy::class, config('backup.cleanup.strategy'));

        $this->commands([
            'command.backup:run',
            'command.backup:clean',
            'command.backup:list',
            'command.backup:monitor',
        ]);

        $this->app->singleton(ConsoleOutput::class);
    }
}
