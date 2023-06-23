#!/usr/bin/env sh

bin/typo3 cache:flush
# Update schema and do NOT delete tables/fields
bin/typo3 database:updateschema "*"
bin/typo3 database:updateschema "*"
bin/typo3 install:extensionsetupifpossible


bin/typo3 database:update "*"
bin/typo3 cache:flush

bin/typo3 language:update
# Run before wizards, to avoid duplicated pages
yes | bin/typo3 upgrade:run
bin/typo3 database:update "*"
bin/typo3 install:fixfolderstructure
