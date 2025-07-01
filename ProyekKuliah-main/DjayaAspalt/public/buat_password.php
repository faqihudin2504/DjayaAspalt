<?php

// Gunakan password 'admin123'
$password = 'admin123'; // <<< UBAH INI JIKA ANDA INGIN MENGHASILKAN HASH UNTUK PASSWORD LAIN

// Buat hash baru menggunakan sistem PHP Anda sendiri
$newHash = password_hash($password, PASSWORD_DEFAULT);

// Tampilkan di layar dengan format yang mudah disalin
echo "<h2>Gunakan Perintah SQL di Bawah Ini</h2>";
echo "<p>Salin semua teks di dalam kotak di bawah ini dan jalankan di phpMyAdmin.</p>";
echo "<textarea rows='5' cols='90' readonly style='font-size: 16px; padding: 10px;'>" . htmlspecialchars("UPDATE users SET password = '" . $newHash . "' WHERE email = 'EMAIL_TARGET_ANDA';") . "</textarea>";
echo "<hr>";
echo "<p><b>Hash baru yang dibuat oleh sistem Anda:</b><br>" . htmlspecialchars($newHash) . "</p>";

?>