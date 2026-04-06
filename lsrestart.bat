taskkill /im LoginServer.exe /f
taskkill /im LoginAgent.exe /f
taskkill /im LoginServer.exe /f
taskkill /im LoginAgent.exe /f
taskkill /im LoginServer.exe /f
taskkill /im LoginAgent.exe /f
timeout /t 1
start /MIN /D"D:\a3server\LoginServer" LoginServer.exe
start /MIN /D"D:\A3Server\LoginAgent_120" LoginAgent.exe
