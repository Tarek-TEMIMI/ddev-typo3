<?php
namespace Deployer;

require 'recipe/common.php';
require 'contrib/rsync.php';

import(__DIR__ . '/servers.yml');

$sharedDirectories = [
    'web/fileadmin',
    'var'
];
set('shared_dirs', $sharedDirectories);

$sharedFiles = [
    '.env',
];
set('shared_files', $sharedFiles);

$writeableDirectories = [
    'web/typo3temp'
];
set('writable_dirs', $writeableDirectories);

// Use composer v2
set('bin/composer', 'composer2');

$exclude = [
    '.composer-cache',
    'CODE_OF_CONDUCT.md',
    'build',
];

set('rsync', [
    'exclude' => array_merge($sharedDirectories, $sharedFiles, $exclude),
    'exclude-file' => false,
    'include' => [],
    'include-file' => false,
    'filter' => ['dir-merge,-n /.gitignore'],
    'filter-file' => false,
    'filter-perdir' => false,
    'flags' => 'avz',
    'options' => ['delete'],
    'timeout' => 300
]);
set('rsync_src', '.');

task('typo3:extension:setup', function () {
    cd('{{release_path}}');
    run('bin/typo3 extension:setup');
});

task('typo3:cache:flush', function() {
    cd('{{release_path}}');
    run('bin/typo3 cache:flush');
});

task('typo3:language:update', function() {
    cd('{{release_path}}');
    run('bin/typo3 language:update');
});

// needed for t3o infrastructure
task('php:reload', function() {
    //run('php-reload');
    run('sudo /usr/sbin/service php74-demo-content reload');
})->select('stage=contentmaster');

task('php:reload-prod', function() {
    //run('php-reload');
    run('sudo /usr/sbin/service php74-demo-prod reload');
})->select('stage=production');

task('typo3:demo:disablelogin', function() {
    cd('{{release_path}}');
    run('{{bin/composer}} remove b13/demologin');
})->select('stage=contentmaster');

task('deploy:update_code')->hidden()->disable();

task('deploy', [
    'deploy:prepare',
    'rsync:warmup',
    'deploy:vendors',
    'deploy:shared',
    'deploy:writable',
    'typo3:extension:setup',
    'deploy:symlink',
    'typo3:demo:disablelogin',
    'php:reload',
    'php:reload-prod',
    'typo3:cache:flush',
    'typo3:language:update',
    'deploy:unlock',
    'deploy:cleanup',
    'deploy:success'
]);

// unlock after failure
after('deploy:failed', 'deploy:unlock');
