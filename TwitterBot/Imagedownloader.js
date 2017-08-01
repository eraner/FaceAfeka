const fs = require('fs');

function downloadImageByString(keyword){
    var child_process = require('child_process');

    var child = child_process.execSync("powershell.exe fim '"+ keyword + "' -d downloaded -n 1").toString();
    var arr = child.trim().split(" ");
    return arr[1];
}