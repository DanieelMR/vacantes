@echo off
echo =====================================
echo     CONFIGURACION PRIMERA VEZ
echo =====================================
echo.
echo Instalando dependencias...
composer install --no-dev

echo.
echo Generando clave...
php artisan key:generate --force

echo.
echo Migrando base de datos...
php artisan migrate --force

echo.
echo Agregando vacantes de ejemplo...
php artisan db:seed --force

echo.
echo ✅ ¡TODO LISTO!
echo.
echo Ahora tienes:
echo - 4 vacantes de muestra
echo - 3 publicadas + 1 pendiente 
echo - 25 postulaciones distribuidas
echo.
echo Para iniciar: INICIAR.cmd
pause
