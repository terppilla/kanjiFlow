$ErrorActionPreference = 'Stop'
$path = Join-Path (Split-Path -Parent $PSScriptRoot) 'resources\views\layouts\navigation.blade.php'
$utf8 = New-Object System.Text.UTF8Encoding $false
$lines = [System.IO.File]::ReadAllLines($path, $utf8)
if ($lines[1] -ne '    <style>') { throw 'Expected inline style block' }
$out = @($lines[0]) + $lines[156..($lines.Length - 1)]
[System.IO.File]::WriteAllLines($path, $out, $utf8)
Write-Host 'Removed inline nav CSS'
