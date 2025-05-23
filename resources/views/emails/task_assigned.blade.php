<!-- resources/views/emails/task_assigned.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas Baru</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); padding: 30px;">

        <h2 style="color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px;">Tugas Baru Telah Diberikan</h2>

        <p style="font-size: 16px; color: #555;">Halo <strong>{{ $task->pengepul->name }}</strong>,</p>

        <p style="font-size: 16px; color: #555;">Anda telah diberikan tugas baru. Berikut adalah detail tugasnya:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #333;">Nama Tugas:</td>
                <td style="padding: 10px; color: #555;">{{ $task->nama_task }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px; font-weight: bold; color: #333;">Status:</td>
                <td style="padding: 10px; color: #555; text-transform: capitalize;">{{ $task->status }}</td>
            </tr>
        </table>

        <p style="font-size: 16px; color: #555;">Silakan buka aplikasi untuk melihat dan mengerjakan tugas ini.</p>

        <div style="margin-top: 30px;">
            <a href="{{ url('/') }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
                Buka Aplikasi
            </a>
        </div>

        <p style="margin-top: 40px; font-size: 14px; color: #aaa;">Email ini dikirim secara otomatis oleh sistem. Harap tidak membalas email ini.</p>
    </div>

</body>
</html>
