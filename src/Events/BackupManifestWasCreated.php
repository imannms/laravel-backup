<?php

namespace Imannms\Backup\Events;

use Imannms\Backup\Tasks\Backup\Manifest;

class BackupManifestWasCreated
{
    /** @var \Spatie\Backup\Tasks\Backup\Manifest */
    public $manifest;

    public function __construct(Manifest $manifest)
    {
        $this->manifest = $manifest;
    }
}
