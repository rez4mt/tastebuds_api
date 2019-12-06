@echo off
if "%1"=="" goto noARG
:con
rmdir /s ".git"
git init
echo # Message >> "README.md"
git add .
git commit -m "First Commit"
git remote add origin %1
git push -u origin master
goto done
:noARG
echo Enter Remote Url.
goto exit
:done
echo done
:exit
