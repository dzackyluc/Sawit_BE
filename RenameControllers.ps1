# Direktori controller
$baseDir = "app\Http\Controllers"

# Daftar file yang ingin diubah: [folder, old name, new name]
$controllers = @(
    @{folder="Api"; old="daftarhargaController.php"; new="DaftarHargaController.php"},
    @{folder="Api"; old="janjitemuController.php"; new="JanjiTemuController.php"},
    @{folder="Api"; old="pengepulController.php"; new="PengepulController.php"},
    @{folder="Api"; old="profileController.php"; new="ProfileController.php"},
    @{folder="Api"; old="taskController.php"; new="TaskController.php"},
    @{folder="Api"; old="transaksiController.php"; new="TransaksiController.php"},
    @{folder="Auth"; old="authController.php"; new="AuthController.php"},
    @{folder="Auth"; old="trackingController.php"; new="TrackingController.php"}
)

foreach ($c in $controllers) {
    $folderPath = Join-Path $baseDir $c.folder
    $oldPath = Join-Path $folderPath $c.old
    $newPath = Join-Path $folderPath $c.new

    if (Test-Path $oldPath) {
        Rename-Item -Path $oldPath -NewName $c.new
        (Get-Content $newPath) -replace "class\s+$(($c.old -replace ".php",""))", "class $($c.new -replace ".php","")" | Set-Content $newPath
        Write-Host "✅ Renamed $($c.old) to $($c.new) and updated class name"
    } else {
        Write-Host "⚠️ File not found: $oldPath"
    }
}
