<?php

use Imannms\Backup\Helpers\ConsoleOutput;

function consoleOutput(): ConsoleOutput
{
    return app(ConsoleOutput::class);
}
