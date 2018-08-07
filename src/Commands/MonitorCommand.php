<?php

namespace Imannms\Backup\Commands;

use Imannms\Backup\Events\HealthyBackupWasFound;
use Imannms\Backup\Events\UnhealthyBackupWasFound;
use Imannms\Backup\Tasks\Monitor\BackupDestinationStatus;
use Imannms\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class MonitorCommand extends BaseCommand
{
    /** @var string */
    protected $signature = 'backup:monitor';

    /** @var string */
    protected $description = 'Monitor the health of all backups.';

    public function handle()
    {
        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitorBackups'));

        $statuses->each(function (BackupDestinationStatus $backupDestinationStatus) {
            if ($backupDestinationStatus->isHealthy()) {
                $this->info("The backups on {$backupDestinationStatus->diskName()} are considered healthy.");
                event(new HealthyBackupWasFound($backupDestinationStatus));

                return;
            }

            $this->error("The backups on {$backupDestinationStatus->diskName()} are considered unhealthy!");
            event(new UnHealthyBackupWasFound($backupDestinationStatus));
        });
    }
}
