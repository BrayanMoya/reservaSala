#!/bin/bash
HOY=`date +%Y%m%d`
echo $HOY
echo "Copiando.. archivos"
cp ./integracion/SessionGuard.php ./vendor/laravel/framework/src/Illuminate/Auth
cp ./integracion/ResetsPasswords.php ./vendor/laravel/framework/src/Illuminate/Foundation/Auth
cp ./integracion/AuthenticatesUsers.php ./vendor/laravel/framework/src/Illuminate/Foundation/Auth
echo "Archivos"
ls -ls ./vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php 
ls -ls ./vendor/laravel/framework/src/Illuminate/Foundation/Auth/ResetsPasswords.php 
ls -ls ./vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php

