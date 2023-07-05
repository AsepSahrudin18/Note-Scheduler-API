# Panduan endpoint:

### 1. Mengambil semua data Schedule

GET /api/schedules

### 2. Pencarian data Schedule berdasarkan tanggal keberlangsungan

<!-- noted: masih progress -->

Back to 🔝

Filter data menggunakan tanggal, misal:

Tanggal 1 juni 2022 sampai 2 juni 2022

### 3. Pencarian data Schedule berdasarkan judul

<!-- noted: masih progress -->

Back to 🔝

Filter data menggunakan judul schedule, misal:

judul LIKE "%Fitness%"

### 4. Pencarian data Schedule berdasarkan ID Schedule

GET /api/schedules/1

### 5. Menambah Schedule Baru: Create data / POST:

endpoint:
/api/schedules/

data yang dikirim:

{
"judul": "Jadwal Baru",
"start_at": "2023-07-04T08:00:00Z",
"end_at": "2023-07-04T12:00:00Z",
"activity": "test"
}

### 6. Mengubah Schedule

PUT /api/schedule/4
Content-Type: application/json

{
"judul": "Schedule Baru yang sudah di update",
"start_at": "2022-06-13T00:00:00Z07:00",
"end_at": "2022-06-13T23:59:59Z07:00",
"activities": [
{
"id": 10,
"activity": "Laboris commodo culpa culpa laboris"
}
]
}

### 7. Menghapus Schedule

DELETE /api/schedule/1

### 8. Mengambil data Aktivitas berdasarkan ID Schedule

GET /api/schedule/1/activities

### 9. Mengambil data Aktivitas berdasarkan ID Aktivitas

GET /api/activity/1

### 10. Menambah Aktivitas baru pada Schedule tertentu

<!-- noted: masih progress -->

### 11. Mengubah Aktivitas pada Schedule tertentu

/api/schedules/3/activities/2

### 12. Menghapus Aktivitas pada Schedule tertentu

DELETE /api/schedules/1/activities/1