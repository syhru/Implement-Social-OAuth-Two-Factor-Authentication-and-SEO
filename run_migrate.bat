@echo off
php artisan migrate:fresh > migrate_test.log 2>&1
echo DONE
