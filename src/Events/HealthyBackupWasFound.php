<?php

namespace Imannms\Backup\Events;

use Imannms\Backup\Tasks\Monitor\BackupDestinationStatus;

class HealthyBackupWasFound
{
    /** @var \Spatie\Backup\Tasks\Monitor\BackupDestinationStatus */
    public $backupDestinationStatus;

    public function __construct(BackupDestinationStatus $backupDestinationStatus)
    {
        $this->backupDestinationStatus = $backupDestinationStatus;
    }
}
