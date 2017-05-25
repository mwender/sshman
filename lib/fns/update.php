<?php
use Humbug\SelfUpdate\Updater;

$updater = new Updater();
$updater->getStrategy()->setPharUrl( 'https://mwender.github.io/sshman/sshman.phar' );
$updater->getStrategy()->setVersionUrl( 'https://mwender.github.io/sshman/sshman.phar.version' );
try {
    $result = $updater->update();
    if (! $result) {
        \cli\line( 'No update needed.' );
        exit(0);
    }
    $new = $updater->getNewVersion();
    $old = $updater->getOldVersion();
    \cli\line( sprintf( 'Updated from %s to %s', $old, $new ) );
    exit(0);
} catch (\Exception $e) {
    \cli\err( 'There was an error while trying to update.' );
    exit(1);
}