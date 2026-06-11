$viewsPath = 'c:/laragon/www/webmin/resources/views'

$bladeFiles = Get-ChildItem -Path $viewsPath -Filter '*.blade.php' -Recurse |
    Where-Object { $_.FullName -notlike '*\layouts\*' -and $_.FullName -notlike '*\auth\*' -and $_.FullName -notlike '*\scribe\*' -and $_.Name -ne 'welcome.blade.php' -and $_.FullName -notlike '*\components\*' }

$count = 0
foreach ($file in $bladeFiles) {
    $lines = Get-Content $file.FullName
    
    # Check if this file has the pattern: second-to-last and third-to-last are </div></x-app-layout>
    # Pattern after cleanup: [..., "    </div>", "</x-app-layout>", ""]
    # We need to remove the "    </div>" that is right before </x-app-layout>
    
    $n = $lines.Count
    
    # Find the last occurrence of </x-app-layout>
    $lastAppLayout = -1
    for ($i = $n - 1; $i -ge 0; $i--) {
        if ($lines[$i].Trim() -eq '</x-app-layout>') {
            $lastAppLayout = $i
            break
        }
    }
    
    if ($lastAppLayout -ge 2) {
        # Check if there's a hanging </div> right before </x-app-layout>
        # (accounting for possible blank line)
        $prevLine = $lines[$lastAppLayout - 1]
        $prevPrevLine = if ($lastAppLayout -ge 2) { $lines[$lastAppLayout - 2] } else { '' }
        
        # Case 1: </div> is directly before </x-app-layout>
        if ($prevLine.Trim() -eq '</div>' -and $prevLine -match '^\s{4}</div>') {
            # Check that there's a matching inner </div> with more indentation
            # to confirm this is an orphaned outer wrapper div
            # Look for </div> with 8 spaces (inner div) before the 4-space one
            $found = $false
            for ($j = $lastAppLayout - 2; $j -ge 0; $j--) {
                if ($lines[$j].Trim() -eq '</div>' -and $lines[$j] -match '^\s{8}</div>') {
                    $found = $true
                    break
                }
            }
            if ($found) {
                $newLines = @()
                for ($i = 0; $i -lt $n; $i++) {
                    if ($i -eq $lastAppLayout - 1) { continue } # Skip the 4-space </div>
                    $newLines += $lines[$i]
                }
                $newLines | Set-Content $file.FullName
                Write-Host "Removed dangling div: $($file.Name)"
                $count++
            }
        }
    }
}
Write-Host ""
Write-Host "Total files fixed: $count"
