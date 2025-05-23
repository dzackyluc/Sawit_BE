<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permintaan Janji Temu</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #333;">📅 Permintaan Janji Temu Baru</h2>
        <p>Seorang petani baru saja mengajukan permintaan janji temu. Berikut adalah detailnya:</p>

        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

        <p><strong>👤 Nama Petani:</strong><br>{{ $janji->nama_petani }}</p>
        <p><strong>📱 Nomor HP:</strong><br>{{ $janji->no_hp }}</p>
        <p><strong>🏡 Alamat:</strong><br>{{ $janji->alamat }}</p>
        <p><strong>🗓️ Tanggal & Waktu:</strong>
            <br>
            {{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}</p>

        <div style="margin: 30px 0; text-align: center;">
            <a href="http://localhost:5173/login" style="background-color: #28a745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                📝 Lihat & Approve Janji Temu
            </a>
        </div>

        <p>Terima kasih telah terus memantau dan merespon pengajuan dari petani.</p>

        <p>Salam hangat,<br><strong>GM Sawit II</strong></p>
    </div>
</body>
</html>
