# Reinforce Lab — daily GitHub sync
# Checks the repo for uncommitted changes and, if any, commits + pushes to origin/main.
# Registered as a Windows Scheduled Task ("ReinforceLab Git Sync"), runs daily.
$ErrorActionPreference = 'Continue'
$repo = 'C:\dev\reinforce-lab'
$log  = Join-Path $repo 'scripts\git-sync.log'

# Scheduled tasks get a minimal PATH — ensure git is resolvable.
$env:Path = 'D:\Git\cmd;' + $env:Path

Set-Location $repo
$ts = Get-Date -Format 'yyyy-MM-dd HH:mm'

$changes = git status --porcelain
if ([string]::IsNullOrWhiteSpace($changes)) {
    Add-Content $log "$ts  no changes"
    exit 0
}

git add -A
git -c commit.gpgsign=false commit -m "Daily sync $ts" 2>&1 | Add-Content $log
$push = git push origin main 2>&1
Add-Content $log "$ts  pushed: $push"
