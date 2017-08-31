ping 127.0.0.1 -n 5 > nul
cd /d %~dp0
cd /d
setlocal enabledelayedexpansion

for /f "tokens=*" %%a in ('type batch.config') do (
    set %%a
)
cd /d %~dp0
%link_PHP_program%  batch.php

pause