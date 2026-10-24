@echo off
title AI Master Agency - CodeIgniter 4 Server
cd /d "C:\xampp\htdocs\ai-master-agency"
echo =======================================================
echo   AI Master Agency - CodeIgniter 4 Enterprise Engine
echo   Starting development server on http://localhost:8080
echo =======================================================
echo.
echo Login Credentials:
echo   Email:    admin@agency.com
echo   Password: admin123
echo.
echo Opening browser...
start http://localhost:8080/login
echo.
C:\xampp\php\php.exe spark serve --port 8080
pause
