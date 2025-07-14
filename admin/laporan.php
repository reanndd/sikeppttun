<?php
$page_title = "Laporan & Grafik";
$current_page = "laporan"; // Untuk menu aktif di sidebar
include 'header.php';
?>

<style>
    .chart-container {
        width: 100%;
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
</style>

<h1>Laporan & Visualisasi Data</h1>
<p>Halaman ini berisi ringkasan data sistem dalam bentuk visual.</p>
<hr>

<div class="chart-container">
    <h3>Jumlah Pengajuan Cuti per Bulan (12 Bulan Terakhir)</h3>
    <canvas id="cutiChart"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen kanvas
        const ctx = document.getElementById('cutiChart').getContext('2d');

        // Ambil data dari server menggunakan fetch API
        fetch('data_grafik_cuti.php')
            .then(response => response.json())
            .then(data => {
                new Chart(ctx, {
                    type: 'bar', // Jenis grafik: batang
                    data: {
                        labels: data.labels, // Label bulan dari server
                        datasets: [{
                            label: 'Jumlah Pengajuan',
                            data: data.values, // Jumlah cuti dari server
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    // Pastikan sumbu Y hanya menampilkan angka bulat
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
</script>

<?php include 'footer.php'; ?>