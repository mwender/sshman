<?php
use Humbug\SelfUpdate\Updater;

$updater = new Updater();
try {
    $result = $updater->rollback();
    if (! $result) {
        \cli\err( 'Unable to rollback. Rollback file not found!' );
        exit 1;
    }
    exit 0;
} catch (\Exception $e) {
    \cli\err( 'Unable to rollback. Error: ' . $e );
    exit 1;
}