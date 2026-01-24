# Run this PowerShell script as Administrator to create a scheduled task that runs the reconcile script every 5 minutes
$taskName = 'DNB_Reconcile_Midtrans'
$phpCmd = "php 'D:\\laragon\\www\\Darkandbright\\scripts\\reconcile_midtrans.php' >> 'D:\\laragon\\www\\Darkandbright\\storage\\logs\\reconcile.log' 2>&1"
Write-Host "Creating scheduled task $taskName"
Start-Process -FilePath schtasks -ArgumentList "/Create","/SC","MINUTE","/MO","5","/TN",$taskName,"/TR",$phpCmd,"/F" -NoNewWindow -Wait
Write-Host "If Start-Process returned without error, scheduled task should be created. Check via: schtasks /Query /TN $taskName"