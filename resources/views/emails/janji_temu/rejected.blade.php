<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penolakan Janji Temu</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #c0392b;">❌ Permintaan Janji Temu Ditolak</h2>
        <p>Dengan hormat,</p>

        <p>Permintaan janji temu yang diajukan oleh seorang petani telah <strong>ditolak</strong>. Berikut detail permintaannya:</p>

        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">

        <p><strong>🗓️ Tanggal & Waktu Pengajuan:</strong><br>
        {{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}</p>

        <p><strong>📍 Lokasi:</strong><br>
        {{ $janji->alamat }}</p>

        <p>Alasan penolakan atau pertimbangan tertentu bisa ditambahkan langsung melalui sistem.</p>

        <div style="margin: 30px 0; text-align: center;">
            <a href="http://localhost:5173/login" style="background-color: #e74c3c; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                🔍 Lihat Detail Penolakan
            </a>
        </div>

        <p>Mohon pastikan untuk memberikan informasi atau penjadwalan ulang jika diperlukan.</p>

        <p>Salam hormat,<br><strong>GM Sawit II</strong></p>
    </div>
</body>
</html>
