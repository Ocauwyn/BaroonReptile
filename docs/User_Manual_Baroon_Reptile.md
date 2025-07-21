# USER MANUAL
# SISTEM INFORMASI PENITIPAN REPTIL "BAROON REPTILE"

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Memulai Sistem](#2-memulai-sistem)
3. [Panduan untuk Customer](#3-panduan-untuk-customer)
4. [Panduan untuk Admin](#4-panduan-untuk-admin)
5. [FAQ (Frequently Asked Questions)](#5-faq-frequently-asked-questions)
6. [Troubleshooting](#6-troubleshooting)
7. [Kontak Support](#7-kontak-support)

---

## 1. PENDAHULUAN

### 1.1 Tentang Baroon Reptile

Baroon Reptile adalah sistem informasi berbasis web untuk layanan penitipan hewan reptil. Sistem ini memungkinkan pemilik reptil untuk menitipkan hewan peliharaan mereka dengan aman dan nyaman, serta memberikan kemudahan bagi administrator untuk mengelola layanan penitipan.

### 1.2 Fitur Utama

#### Untuk Customer:
- ✅ Registrasi dan login akun
- ✅ Manajemen profil reptil
- ✅ Pembuatan booking penitipan
- ✅ Tracking status booking
- ✅ Riwayat penitipan
- ✅ Manajemen profil personal

#### Untuk Admin:
- ✅ Dashboard monitoring
- ✅ Manajemen customer
- ✅ Manajemen reptil
- ✅ Manajemen booking
- ✅ Manajemen pembayaran
- ✅ Manajemen fasilitas
- ✅ Laporan harian
- ✅ Pengaturan sistem

### 1.3 Persyaratan Sistem

#### Browser yang Didukung:
- Google Chrome (versi terbaru)
- Mozilla Firefox (versi terbaru)
- Microsoft Edge (versi terbaru)
- Safari (versi terbaru)

#### Koneksi Internet:
- Koneksi internet stabil
- Kecepatan minimum 1 Mbps

---

## 2. MEMULAI SISTEM

### 2.1 Mengakses Website

1. Buka browser web Anda
2. Ketik alamat: `http://localhost/baroonreptil/` (untuk development)
3. Tekan Enter
4. Halaman utama Baroon Reptile akan tampil

### 2.2 Registrasi Akun Baru

#### Langkah-langkah Registrasi:

1. **Klik tombol "Daftar"** di halaman utama
   
2. **Isi form registrasi:**
   - Username: Pilih username unik (3-20 karakter)
   - Email: Masukkan email valid
   - Password: Minimal 6 karakter
   - Konfirmasi Password: Ulangi password
   - Nama Lengkap: Nama sesuai identitas
   - Nomor Telepon: Nomor yang dapat dihubungi
   - Alamat: Alamat lengkap

3. **Klik "Daftar"**

4. **Verifikasi berhasil:** Anda akan diarahkan ke halaman login

> **💡 Tips:** Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol

### 2.3 Login ke Sistem

#### Langkah-langkah Login:

1. **Klik tombol "Masuk"** di halaman utama

2. **Masukkan kredensial:**
   - Username atau Email
   - Password

3. **Klik "Masuk"**

4. **Berhasil login:** Anda akan diarahkan ke dashboard sesuai role

#### Demo Akun:
```
Admin:
Username: admin
Password: admin123

Customer:
Username: customer1
Password: customer123
```

---

## 3. PANDUAN UNTUK CUSTOMER

### 3.1 Dashboard Customer

Setelah login, Anda akan melihat dashboard dengan informasi:
- **Statistik:** Total reptil, booking aktif, total pengeluaran
- **Reptil Saya:** Daftar reptil yang terdaftar
- **Booking Terbaru:** Riwayat booking terkini
- **Grafik:** Visualisasi data booking

### 3.2 Mengelola Profil Reptil

#### 3.2.1 Menambah Reptil Baru

1. **Navigasi:** Sidebar → "Reptil Saya" → "Tambah Reptil"

2. **Isi informasi reptil:**
   - **Nama Reptil:** Nama panggilan reptil
   - **Kategori:** Pilih dari dropdown (Ular, Kadal, Kura-kura, dll)
   - **Spesies:** Jenis spesies reptil
   - **Umur:** Umur dalam bulan
   - **Berat:** Berat dalam gram
   - **Panjang:** Panjang dalam cm
   - **Jenis Kelamin:** Jantan/Betina/Tidak Diketahui
   - **Foto:** Upload foto reptil (max 5MB, format JPG/PNG)
   - **Kebutuhan Khusus:** Catatan perawatan khusus

3. **Klik "Simpan Reptil"**

> **📝 Catatan:** Informasi kategori akan menampilkan harga penitipan per hari

#### 3.2.2 Mengedit Reptil

1. **Navigasi:** Sidebar → "Reptil Saya"
2. **Pilih reptil** yang ingin diedit
3. **Klik tombol "Edit"**
4. **Ubah informasi** yang diperlukan
5. **Klik "Update Reptil"**

> **⚠️ Perhatian:** Beberapa field tidak dapat diubah jika reptil sedang dalam booking aktif

#### 3.2.3 Menghapus Reptil

1. **Navigasi:** Sidebar → "Reptil Saya"
2. **Pilih reptil** yang ingin dihapus
3. **Klik tombol "Hapus"**
4. **Konfirmasi penghapusan**

> **⚠️ Perhatian:** Reptil tidak dapat dihapus jika memiliki booking aktif

### 3.3 Membuat Booking Penitipan

#### 3.3.1 Langkah-langkah Booking

1. **Navigasi:** Sidebar → "Booking" → "Buat Booking"

2. **Pilih Reptil:**
   - Pilih reptil dari dropdown
   - Informasi reptil dan harga akan ditampilkan

3. **Tentukan Tanggal:**
   - **Tanggal Mulai:** Tanggal check-in
   - **Tanggal Selesai:** Tanggal check-out
   - Sistem akan menghitung total hari otomatis

4. **Pilih Fasilitas Tambahan (Opsional):**
   - Kandang Premium
   - Perawatan Khusus
   - Makanan Premium
   - Monitoring 24/7
   - dll.

5. **Tambahkan Catatan Khusus (Opsional):**
   - Instruksi perawatan
   - Kebiasaan reptil
   - Kontak darurat

6. **Review Total Biaya:**
   - Biaya dasar: (Harga per hari × Total hari)
   - Biaya fasilitas: (Harga fasilitas × Total hari)
   - **Total: Biaya dasar + Biaya fasilitas**

7. **Klik "Buat Booking"**

#### 3.3.2 Status Booking

- **🟡 Pending:** Booking baru, menunggu konfirmasi admin
- **🟢 Confirmed:** Booking dikonfirmasi, siap untuk check-in
- **🔵 Active:** Reptil sedang dalam penitipan
- **✅ Completed:** Penitipan selesai
- **❌ Cancelled:** Booking dibatalkan

### 3.4 Mengelola Booking

#### 3.4.1 Melihat Riwayat Booking

1. **Navigasi:** Sidebar → "Booking"
2. **Filter berdasarkan status** (All, Pending, Confirmed, dll)
3. **Gunakan pencarian** untuk mencari booking tertentu
4. **Klik "Detail"** untuk melihat informasi lengkap

#### 3.4.2 Membatalkan Booking

1. **Navigasi:** Sidebar → "Booking"
2. **Pilih booking** dengan status Pending atau Confirmed
3. **Klik "Batalkan"**
4. **Konfirmasi pembatalan**

> **📝 Catatan:** Booking yang sudah Active tidak dapat dibatalkan

### 3.5 Mengelola Profil

#### 3.5.1 Update Informasi Profil

1. **Navigasi:** Sidebar → "Profil" → Tab "Informasi Profil"

2. **Edit informasi:**
   - Nama Lengkap
   - Email
   - Nomor Telepon
   - Alamat

3. **Klik "Update Profil"**

#### 3.5.2 Mengubah Password

1. **Navigasi:** Sidebar → "Profil" → Tab "Ubah Password"

2. **Isi form:**
   - Password Lama
   - Password Baru
   - Konfirmasi Password Baru

3. **Klik "Update Password"**

> **🔒 Keamanan:** Gunakan password yang kuat dan unik

### 3.6 Pengaturan Akun

#### 3.6.1 Notifikasi

1. **Navigasi:** Sidebar → "Pengaturan" → Tab "Notifikasi"

2. **Atur preferensi:**
   - ✅ Email Notifikasi
   - ✅ Pengingat Booking
   - ✅ Email Promosi

3. **Klik "Simpan Pengaturan"**

#### 3.6.2 Privasi

1. **Navigasi:** Sidebar → "Pengaturan" → Tab "Privasi"

2. **Atur pengaturan:**
   - Visibilitas Profil
   - Riwayat Booking
   - Izin Kontak

3. **Klik "Simpan Pengaturan"**

---

## 4. PANDUAN UNTUK ADMIN

### 4.1 Dashboard Admin

Dashboard admin menampilkan:
- **Statistik Utama:** Total customer, reptil, booking, revenue
- **Grafik Booking:** Trend booking bulanan
- **Grafik Kategori:** Distribusi kategori reptil
- **Booking Terbaru:** Daftar booking terkini

### 4.2 Manajemen Customer

#### 4.2.1 Melihat Daftar Customer

1. **Navigasi:** Sidebar → "Customer"

2. **Fitur yang tersedia:**
   - **Filter:** Status (Active/Inactive)
   - **Sorting:** Terbaru, Terlama, Nama, Total Booking
   - **Pencarian:** Berdasarkan nama atau email

3. **Informasi yang ditampilkan:**
   - Data personal customer
   - Statistik reptil dan booking
   - Total pengeluaran
   - Tanggal bergabung

#### 4.2.2 Mengelola Status Customer

1. **Pilih customer** dari daftar
2. **Klik tombol status** (Aktifkan/Nonaktifkan)
3. **Konfirmasi perubahan**

> **⚠️ Perhatian:** Customer yang dinonaktifkan tidak dapat login

### 4.3 Manajemen Reptil

#### 4.3.1 Melihat Daftar Reptil

1. **Navigasi:** Sidebar → "Reptil"

2. **Filter dan sorting:**
   - **Status:** Active/Inactive
   - **Kategori:** Semua kategori
   - **Sorting:** Terbaru, Terlama, Nama, Kategori, Most Bookings

3. **Statistik reptil:**
   - Total reptil
   - Reptil aktif/tidak aktif
   - Reptil baru (hari ini/minggu ini)
   - Statistik per kategori

#### 4.3.2 Mengelola Status Reptil

1. **Pilih reptil** dari daftar
2. **Klik tombol status** untuk mengubah status
3. **Konfirmasi perubahan**

#### 4.3.3 Menghapus Reptil

1. **Pilih reptil** yang ingin dihapus
2. **Klik tombol "Hapus"**
3. **Konfirmasi penghapusan**

> **⚠️ Perhatian:** Reptil dengan booking aktif tidak dapat dihapus

### 4.4 Manajemen Booking

#### 4.4.1 Melihat Daftar Booking

1. **Navigasi:** Sidebar → "Booking"

2. **Filter booking:**
   - **Status:** All, Pending, Confirmed, Active, Completed, Cancelled
   - **Tanggal:** Range tanggal tertentu

3. **Informasi booking:**
   - Data customer dan reptil
   - Tanggal dan durasi
   - Fasilitas yang dipilih
   - Total biaya
   - Status pembayaran

#### 4.4.2 Mengubah Status Booking

1. **Pilih booking** dari daftar
2. **Klik dropdown status**
3. **Pilih status baru:**
   - Pending → Confirmed
   - Confirmed → Active
   - Active → Completed
   - Any → Cancelled
4. **Konfirmasi perubahan**

### 4.5 Manajemen Pembayaran

#### 4.5.1 Melihat Daftar Pembayaran

1. **Navigasi:** Sidebar → "Pembayaran"

2. **Filter pembayaran:**
   - **Status:** Pending, Paid, Failed, Refunded
   - **Metode:** Cash, Transfer, Credit Card
   - **Tanggal:** Range tanggal

3. **Statistik pembayaran:**
   - Total revenue
   - Pending amount
   - Breakdown per metode

#### 4.5.2 Update Status Pembayaran

1. **Pilih pembayaran** dari daftar
2. **Klik dropdown status**
3. **Pilih status baru**
4. **Tambahkan catatan** (opsional)
5. **Konfirmasi update**

#### 4.5.3 Membuat Pembayaran Baru

1. **Klik "Tambah Pembayaran"**
2. **Pilih booking** yang belum memiliki pembayaran
3. **Isi detail pembayaran:**
   - Jumlah
   - Metode pembayaran
   - Catatan
4. **Klik "Simpan"**

### 4.6 Manajemen Fasilitas

#### 4.6.1 Melihat Daftar Fasilitas

1. **Navigasi:** Sidebar → "Fasilitas"

2. **Informasi fasilitas:**
   - Nama dan deskripsi
   - Harga per hari
   - Status (Active/Inactive)
   - Popularitas (berapa kali dipilih)

#### 4.6.2 Menambah Fasilitas Baru

1. **Klik "Tambah Fasilitas"**
2. **Isi form:**
   - Nama Fasilitas
   - Deskripsi
   - Harga per Hari
   - Status
3. **Klik "Simpan"**

#### 4.6.3 Mengedit Fasilitas

1. **Pilih fasilitas** dari daftar
2. **Klik "Edit"**
3. **Ubah informasi** yang diperlukan
4. **Klik "Update"**

#### 4.6.4 Menghapus Fasilitas

1. **Pilih fasilitas** yang ingin dihapus
2. **Klik "Hapus"**
3. **Konfirmasi penghapusan**

> **⚠️ Perhatian:** Fasilitas yang sedang digunakan dalam booking aktif tidak dapat dihapus

### 4.7 Laporan Harian

#### 4.7.1 Melihat Laporan

1. **Navigasi:** Sidebar → "Laporan"

2. **Filter laporan:**
   - **Tanggal:** Pilih tanggal tertentu
   - **Sorting:** Terbaru atau Terlama

3. **Informasi laporan:**
   - Total booking hari itu
   - Total revenue
   - Jumlah reptil aktif
   - Catatan khusus

#### 4.7.2 Membuat Laporan Baru

1. **Klik "Buat Laporan"**
2. **Pilih tanggal** laporan
3. **Isi data:**
   - Total Booking (otomatis terisi)
   - Total Revenue (otomatis terisi)
   - Reptil Aktif (otomatis terisi)
   - Catatan (manual)
4. **Klik "Simpan Laporan"**

#### 4.7.3 Quick Action - Laporan Hari Ini

1. **Klik "Buat Laporan Hari Ini"**
2. **Data otomatis terisi** berdasarkan aktivitas hari ini
3. **Tambahkan catatan** jika diperlukan
4. **Klik "Simpan"**

### 4.8 Pengaturan Sistem

#### 4.8.1 Profil Admin

1. **Navigasi:** Sidebar → "Pengaturan" → Tab "Profil"
2. **Update informasi:**
   - Nama Lengkap
   - Email
   - Nomor Telepon
   - Alamat
3. **Klik "Update Profil"**

#### 4.8.2 Ubah Password

1. **Navigasi:** Tab "Keamanan"
2. **Isi form ubah password**
3. **Klik "Update Password"**

#### 4.8.3 Konfigurasi Sistem

1. **Navigasi:** Tab "Sistem"
2. **Atur konfigurasi:**
   - **Informasi Situs:**
     - Nama Situs
     - Deskripsi
     - Email Kontak
     - Nomor Telepon
   - **Aturan Booking:**
     - Minimum hari booking
     - Maximum hari booking
     - Batas waktu pembatalan
3. **Klik "Simpan Pengaturan"**

---

## 5. FAQ (FREQUENTLY ASKED QUESTIONS)

### 5.1 Pertanyaan Umum

**Q: Bagaimana cara reset password jika lupa?**
A: Saat ini fitur reset password belum tersedia. Silakan hubungi admin untuk reset password.

**Q: Apakah bisa mengubah booking yang sudah dibuat?**
A: Booking yang sudah dibuat tidak dapat diubah. Anda perlu membatalkan booking lama dan membuat booking baru.

**Q: Berapa lama sebelum booking dikonfirmasi?**
A: Booking biasanya dikonfirmasi dalam 1x24 jam oleh admin.

**Q: Apakah ada batasan jumlah reptil yang bisa didaftarkan?**
A: Tidak ada batasan jumlah reptil yang dapat didaftarkan per customer.

**Q: Bagaimana cara mengetahui status booking saya?**
A: Anda dapat melihat status booking di halaman "Booking" pada dashboard customer.

### 5.2 Pertanyaan Teknis

**Q: Browser apa yang direkomendasikan?**
A: Google Chrome, Mozilla Firefox, Microsoft Edge, atau Safari versi terbaru.

**Q: Apakah website ini mobile-friendly?**
A: Ya, website ini responsive dan dapat diakses dengan baik di perangkat mobile.

**Q: Ukuran maksimal file foto yang bisa diupload?**
A: Maksimal 5MB dengan format JPG, PNG, atau GIF.

**Q: Apakah data saya aman?**
A: Ya, sistem menggunakan enkripsi password dan validasi input untuk keamanan data.

### 5.3 Pertanyaan Bisnis

**Q: Bagaimana cara pembayaran?**
A: Pembayaran dapat dilakukan secara cash, transfer bank, atau kartu kredit.

**Q: Apakah ada diskon untuk booking jangka panjang?**
A: Saat ini belum ada sistem diskon otomatis. Hubungi admin untuk penawaran khusus.

**Q: Bisakah membatalkan booking?**
A: Ya, booking dengan status Pending atau Confirmed dapat dibatalkan.

**Q: Apakah ada asuransi untuk reptil yang dititipkan?**
A: Informasi mengenai asuransi dapat ditanyakan langsung kepada admin.

---

## 6. TROUBLESHOOTING

### 6.1 Masalah Login

#### Problem: Tidak bisa login
**Solusi:**
1. ✅ Pastikan username/email dan password benar
2. ✅ Periksa caps lock
3. ✅ Pastikan akun tidak dinonaktifkan
4. ✅ Clear browser cache dan cookies
5. ✅ Coba browser lain

#### Problem: Lupa password
**Solusi:**
1. Hubungi admin untuk reset password
2. Berikan informasi akun (username/email)

### 6.2 Masalah Upload File

#### Problem: Gagal upload foto reptil
**Solusi:**
1. ✅ Periksa ukuran file (max 5MB)
2. ✅ Periksa format file (JPG, PNG, GIF)
3. ✅ Pastikan koneksi internet stabil
4. ✅ Coba compress foto terlebih dahulu

### 6.3 Masalah Booking

#### Problem: Tidak bisa membuat booking
**Solusi:**
1. ✅ Pastikan reptil sudah terdaftar
2. ✅ Periksa tanggal (tidak boleh masa lalu)
3. ✅ Pastikan tidak ada booking yang overlap
4. ✅ Periksa status reptil (harus active)

#### Problem: Booking tidak muncul
**Solusi:**
1. ✅ Refresh halaman
2. ✅ Periksa filter status
3. ✅ Gunakan fitur pencarian

### 6.4 Masalah Tampilan

#### Problem: Tampilan tidak normal
**Solusi:**
1. ✅ Refresh halaman (Ctrl+F5)
2. ✅ Clear browser cache
3. ✅ Update browser ke versi terbaru
4. ✅ Disable browser extensions
5. ✅ Coba browser lain

#### Problem: Website lambat
**Solusi:**
1. ✅ Periksa koneksi internet
2. ✅ Close tab browser lain
3. ✅ Restart browser
4. ✅ Coba di waktu yang berbeda

### 6.5 Error Messages

#### "Database connection failed"
**Solusi:**
1. Tunggu beberapa menit dan coba lagi
2. Hubungi admin jika masalah berlanjut

#### "Session expired"
**Solusi:**
1. Login ulang
2. Pastikan tidak idle terlalu lama

#### "Access denied"
**Solusi:**
1. Pastikan login dengan akun yang benar
2. Periksa role akun (customer/admin)

#### "File too large"
**Solusi:**
1. Compress file sebelum upload
2. Gunakan format yang lebih efisien

---

## 7. KONTAK SUPPORT

### 7.1 Informasi Kontak

**📧 Email Support:**
support@baroonreptile.com

**📞 Telepon:**
+62 123 456 7890

**💬 WhatsApp:**
+62 812 3456 7890

**🏢 Alamat:**
Jl. Reptil Indah No. 123
Jakarta Selatan 12345
Indonesia

### 7.2 Jam Operasional

**Senin - Jumat:**
08:00 - 17:00 WIB

**Sabtu:**
08:00 - 12:00 WIB

**Minggu:**
Tutup

### 7.3 Response Time

- **Email:** 1x24 jam
- **Telepon:** Langsung (jam kerja)
- **WhatsApp:** 2-4 jam

### 7.4 Jenis Dukungan

✅ **Technical Support:**
- Masalah login
- Error sistem
- Troubleshooting

✅ **Account Support:**
- Reset password
- Update informasi
- Aktivasi/deaktivasi akun

✅ **Business Support:**
- Informasi layanan
- Pertanyaan billing
- Feedback dan saran

---

## 8. FITUR LANJUTAN

### 8.1 Operasi Bulk

#### 8.1.1 Import Reptil Massal
**Untuk Customer:**
1. Navigasi ke **Manajemen Reptil** → **Import Massal**
2. Download template CSV
3. Isi informasi reptil:
   ```csv
   nama,spesies,kategori,umur,berat,deskripsi
   "Gecko Biru","Tokay Gecko","Gecko",2,150,"Gecko sehat dan aktif"
   "Iguana Hijau","Green Iguana","Iguana",3,800,"Iguana jinak dan ramah"
   ```
4. Upload file CSV yang sudah diisi
5. Review dan konfirmasi import
6. Sistem akan validasi dan import semua reptil

#### 8.1.2 Manajemen Booking Massal
**Untuk Admin:**
1. Ke **Panel Admin** → **Booking** → **Aksi Massal**
2. Pilih multiple booking menggunakan checkbox
3. Pilih aksi:
   - **Konfirmasi Terpilih**: Konfirmasi multiple booking pending
   - **Batalkan Terpilih**: Batalkan multiple booking
   - **Export Terpilih**: Export detail booking ke Excel
   - **Kirim Notifikasi**: Kirim notifikasi massal

### 8.2 Pencarian dan Filter Lanjutan

#### 8.2.1 Smart Search
**Sintaks Pencarian:**
- **Dasar**: Ketik keyword apapun (contoh: "gecko")
- **Frasa Eksak**: Gunakan tanda kutip (contoh: "tokay gecko")
- **Multiple terms**: Gunakan AND/OR (contoh: "gecko AND biru")
- **Exclude terms**: Gunakan tanda minus (contoh: "reptil -ular")
- **Range tanggal**: Gunakan format YYYY-MM-DD (contoh: "2024-01-01 to 2024-12-31")

**Filter Lanjutan:**
```
Spesies: [Dropdown dengan semua spesies]
Range Umur: [Slider: 0-20 tahun]
Range Berat: [Slider: 0-5000g]
Lokasi: [Multi-select fasilitas]
Ketersediaan: [Tersedia/Dipesan/Maintenance]
Status Kesehatan: [Sehat/Dalam Perawatan/Karantina]
```

### 8.3 Laporan dan Analitik

#### 8.3.1 Laporan Customer
**Laporan Riwayat Booking:**
1. Ke **Akun Saya** → **Laporan**
2. Pilih **Riwayat Booking**
3. Pilih range tanggal dan filter
4. Generate laporan dalam format PDF/Excel

**Laporan Perawatan Reptil:**
- Aktivitas perawatan harian
- Record pemeriksaan kesehatan
- Jadwal pemberian makan
- Timeline foto

#### 8.3.2 Dashboard Analitik Admin
**Metrik Utama:**
- Tingkat okupansi per fasilitas
- Trend revenue
- Skor kepuasan customer
- Spesies reptil populer
- Pola booking musiman

---

## 9. APLIKASI MOBILE

### 9.1 Fitur Aplikasi Mobile

#### 9.1.1 Download dan Instalasi
**Android:**
1. Buka Google Play Store
2. Cari "Baroon Reptile"
3. Tap **Install**
4. Buka app dan login dengan kredensial Anda

**iOS:**
1. Buka App Store
2. Cari "Baroon Reptile"
3. Tap **Get**
4. Buka app dan login dengan kredensial Anda

#### 9.1.2 Fitur Khusus Mobile
**Push Notifications:**
- Konfirmasi booking
- Update perawatan harian
- Pengingat pembayaran
- Alert darurat

**Integrasi Kamera:**
- Upload foto reptil dengan cepat
- Scan QR code untuk check-in fasilitas
- Scan dokumen untuk sertifikat kesehatan

**Mode Offline:**
- Lihat informasi reptil yang di-cache
- Akses detail kontak darurat
- Sinkronisasi data saat koneksi pulih

---

## 10. KEAMANAN DAN PRIVASI

### 10.1 Keamanan Akun

#### 10.1.1 Two-Factor Authentication (2FA)
**Setup 2FA:**
1. Ke **Akun Saya** → **Keamanan**
2. Klik **Aktifkan Two-Factor Authentication**
3. Pilih metode:
   - **SMS**: Terima kode via pesan teks
   - **Authenticator App**: Gunakan Google Authenticator atau sejenisnya
   - **Email**: Terima kode via email
4. Ikuti instruksi setup
5. Simpan backup codes di tempat aman

#### 10.1.2 Keamanan Password
**Persyaratan Password:**
- Minimum 8 karakter
- Minimal satu huruf besar
- Minimal satu huruf kecil
- Minimal satu angka
- Minimal satu karakter khusus
- Tidak boleh sama dengan 5 password terakhir

### 10.2 Privasi Data

#### 10.2.1 Pengumpulan Data
**Kami mengumpulkan:**
- Informasi akun (nama, email, telepon)
- Informasi reptil (spesies, foto, record kesehatan)
- Riwayat booking dan pembayaran
- Analitik penggunaan (anonim)
- Preferensi komunikasi

**Kami TIDAK mengumpulkan:**
- Data personal sensitif (KTP, passport)
- Informasi finansial (disimpan oleh payment processor)
- Data lokasi (kecuali diizinkan eksplisit)
- Data biometrik

---

## LAMPIRAN

### A. Shortcut Keyboard

#### A.1 Navigasi Umum
| Shortcut | Fungsi | Konteks |
|----------|--------|---------|
| Ctrl + S | Simpan form saat ini | Semua form |
| Ctrl + N | Buat entry baru | List views |
| Ctrl + F | Pencarian/Filter | Semua halaman |
| Ctrl + R | Refresh halaman | Semua halaman |
| Esc | Tutup modal/dialog | Modal |
| Tab | Navigasi antar field | Form |
| Shift + Tab | Navigasi mundur | Form |
| Enter | Submit form | Form |
| Ctrl + Z | Undo aksi terakhir | Editor |
| Ctrl + Y | Redo aksi terakhir | Editor |

#### A.2 Shortcut Lanjutan
| Shortcut | Fungsi | Konteks |
|----------|--------|---------|
| Ctrl + Shift + N | Booking baru | Dashboard |
| Ctrl + Shift + R | Reptil baru | Manajemen reptil |
| Ctrl + Shift + F | Pencarian lanjutan | Semua halaman |
| Ctrl + Shift + E | Export data | Laporan |
| Ctrl + Shift + P | Print halaman | Semua halaman |
| Alt + 1-9 | Navigasi cepat | Menu utama |
| Ctrl + / | Tampilkan bantuan | Semua halaman |

### B. Status Codes dan Error Messages

#### B.1 HTTP Status Codes
| Code | Status | Deskripsi | Aksi User |
|------|--------|-----------|----------|
| 200 | Success | Operasi berhasil | Lanjutkan normal |
| 201 | Created | Resource dibuat | Verifikasi resource baru |
| 400 | Bad Request | Data input tidak valid | Periksa field form |
| 401 | Unauthorized | Login diperlukan | Login ke akun |
| 403 | Forbidden | Akses ditolak | Hubungi administrator |
| 404 | Not Found | Resource tidak ditemukan | Periksa URL atau cari |
| 409 | Conflict | Konflik resource | Selesaikan konflik |
| 422 | Validation Error | Validasi data gagal | Perbaiki error validasi |
| 429 | Rate Limited | Terlalu banyak request | Tunggu dan coba lagi |
| 500 | Server Error | Error server internal | Hubungi support |

#### B.2 Application Error Codes
| Code | Tipe Error | Deskripsi | Resolusi |
|------|------------|-----------|----------|
| AUTH001 | Invalid Credentials | Username/password salah | Reset password |
| AUTH002 | Account Locked | Terlalu banyak percobaan gagal | Tunggu atau hubungi support |
| BOOK001 | Booking Conflict | Tanggal/waktu sudah dipesan | Pilih tanggal berbeda |
| BOOK002 | Insufficient Capacity | Fasilitas penuh | Pilih fasilitas berbeda |
| PAY001 | Payment Failed | Error pemrosesan pembayaran | Coba metode pembayaran lain |
| FILE001 | File Too Large | File melebihi batas ukuran | Kompres atau resize file |
| FILE002 | Invalid Format | Tipe file tidak didukung | Gunakan format yang didukung |
| SYS001 | Database Error | Masalah koneksi database | Hubungi support |

### C. Format File yang Didukung

#### C.1 File Gambar
**Format yang Didukung:**
- **JPEG** (.jpg, .jpeg)
  - Ukuran maksimal: 5MB
  - Resolusi rekomendasi: 1920x1080
  - Color space: sRGB
  - Kualitas: 80-90%

- **PNG** (.png)
  - Ukuran maksimal: 5MB
  - Mendukung transparansi
  - Terbaik untuk grafik dan logo
  - Kompresi lossless

- **GIF** (.gif)
  - Ukuran maksimal: 2MB
  - Mendukung animasi
  - Terbatas 256 warna
  - Terbaik untuk grafik sederhana

**Tips Optimasi Gambar:**
```
Best Practices:
- Gunakan JPEG untuk foto
- Gunakan PNG untuk grafik dengan transparansi
- Optimasi gambar sebelum upload
- Gunakan nama file yang deskriptif
- Sertakan alt text untuk aksesibilitas
```

#### C.2 File Dokumen
**Format yang Didukung:**
- **PDF** (.pdf)
  - Ukuran maksimal: 10MB
  - Versi: PDF 1.4 atau lebih tinggi
  - Password protection didukung

- **Microsoft Word** (.doc, .docx)
  - Ukuran maksimal: 10MB
  - Versi: Word 2007 atau lebih tinggi
  - Gambar embedded didukung

- **Microsoft Excel** (.xls, .xlsx)
  - Ukuran maksimal: 10MB
  - Versi: Excel 2007 atau lebih tinggi
  - Multiple sheets didukung

- **Text Files** (.txt, .csv)
  - Ukuran maksimal: 5MB
  - Encoding UTF-8 direkomendasikan
  - CSV dengan comma delimiter

### D. Glossary

**API (Application Programming Interface)**: Sekumpulan protokol dan tools untuk membangun aplikasi software.

**Booking**: Reservasi untuk layanan perawatan reptil di fasilitas tertentu untuk periode waktu yang ditentukan.

**Fasilitas**: Lokasi fisik atau kandang tempat reptil ditempatkan dan dirawat.

**JWT (JSON Web Token)**: Cara kompak dan aman untuk merepresentasikan klaim yang ditransfer antar pihak.

**QR Code**: Jenis matrix barcode yang dapat dibaca oleh smartphone dan perangkat lain.

**Rate Limiting**: Teknik untuk membatasi traffic jaringan dengan membatasi jumlah request yang dapat dibuat user.

**Reptile Profile**: Record komprehensif yang berisi semua informasi tentang reptil tertentu.

**Two-Factor Authentication (2FA)**: Lapisan keamanan tambahan yang memerlukan dua faktor autentikasi berbeda.

**Webhook**: Metode untuk menambah atau mengubah perilaku halaman web dengan custom callbacks.

---

**© 2024 Baroon Reptile. All rights reserved.**

*Dokumen ini akan diupdate secara berkala sesuai dengan pengembangan sistem.*

**Versi Dokumen:** 2.0  
**Tanggal Update:** Desember 2024  
**Review Berikutnya:** Maret 2025

**Kontak Support:**  
📧 Email: support@baroonreptile.com  
📞 Telepon: +62-XXX-XXXX-XXXX  
🌐 Website: https://baroonreptile.com  
💬 Live Chat: Tersedia 24/7 di website