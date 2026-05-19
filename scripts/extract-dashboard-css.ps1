$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
$bladePath = Join-Path $root 'resources\views\user\dashboard.blade.php'
$cssPath = Join-Path $root 'public\css\dashboard.css'
$utf8 = New-Object System.Text.UTF8Encoding $false

$lines = [System.IO.File]::ReadAllLines($bladePath, $utf8)
if ($lines[1] -ne '    <style>') {
    throw "Unexpected dashboard.blade.php structure at line 2: $($lines[1])"
}

$css = ($lines[2..1223] -join [Environment]::NewLine) + [Environment]::NewLine
[System.IO.File]::WriteAllText($cssPath, $css, $utf8)

$newLines = New-Object System.Collections.Generic.List[string]
$newLines.Add($lines[0])
$newLines.Add("    @push('styles')")
$newLines.Add('    <link rel="stylesheet" href="{{ asset(''css/dashboard.css'') }}">')
$newLines.Add('@endpush')
$newLines.Add('')
for ($i = 1225; $i -lt $lines.Length; $i++) {
    $newLines.Add($lines[$i])
}

[System.IO.File]::WriteAllLines($bladePath, $newLines, $utf8)
Write-Host "Extracted $($lines[2..1223].Length) CSS lines to $cssPath"
