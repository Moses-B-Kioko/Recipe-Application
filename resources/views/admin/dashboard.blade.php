@extends('admin.layouts.app')

@section('content')
<h1 style="text-align: center;">Dashboard</h1>

<div class="container-fluid">
    <!-- Export Buttons -->
    <div class="export-buttons mb-3" style="text-align: center;">
        <button id="exportCSV" class="btn btn-secondary" style="margin-right: 5px;">Export CSV</button>
        <button id="exportExcel" class="btn btn-success" style="margin-right: 5px;">Export Excel</button>
        <button id="downloadPDF" class="btn btn-primary" style="margin-right: 5px;">Download PDF</button>
    </div>

    <div class="row mb-4">
        <!-- Total Sales Card -->
        <div class="col-md-3">
            <div class="card" style="background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s;">
                <div class="card-body">
                    <h5 class="card-title">Total Sales:</h5>
                    <p class="card-text">Ksh.{{ $totalSales }}</p>
                </div>
            </div>
        </div>
        <!-- Total Orders Card -->
        <div class="col-md-3">
            <div class="card" style="background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s;">
                <div class="card-body">
                    <h5 class="card-title">Total Orders:</h5>
                    <p class="card-text">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <!-- Best-Selling Category Card -->
        <div class="col-md-3">
            <div class="card" style="background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s;">
                <div class="card-body">
                    <h5 class="card-title">Best Selling Category:</h5>
                    <p class="card-text">{{ $bestCategory->name }}</p>
                </div>
            </div>
        </div>
        <!-- Total Users Card -->
        <div class="col-md-3">
            <div class="card" style="background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s;">
                <div class="card-body">
                    <h5 class="card-title">Total Users:</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <span class="visually-hidden">Loading...</span>
    </div>

    <h3 style="text-align: center;">Charts</h3>

    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-bottom: 20px;">
        <div style="flex: 1; margin-right: 10px;">
            <canvas id="salesOverTime" width="400" height="200"></canvas>
        </div>
        <div style="flex: 1; margin-left: 10px;">
            <canvas id="topSellingBooks" width="400" height="200"></canvas>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
        <div style="flex: 1; margin-right: 10px;">
            <canvas id="salesByCategory" width="400" height="200"></canvas>
        </div>
        <div>
            <canvas id="revenueByCountyChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart data
        const salesOverTimeLabels = @json($labels);
        const salesOverTimeData = @json($values);
        const bookLabels = @json($bookLabels);
        const bookValues = @json($bookValues);
        const categoryLabels = @json($categoryLabels);
        const categoryValues = @json($categoryValues);
        const countyLabels = @json($countyLabels);
        const countyRevenue = @json($countyRevenue);

        // Sales Over Time Chart
        const ctx1 = document.getElementById('salesOverTime').getContext('2d');
        const salesOverTimeChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: salesOverTimeLabels,
                datasets: [{
                    label: 'Total Sales Over Time',
                    data: salesOverTimeData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Sales (Grand Total)' }
                    },
                    x: {
                        title: { display: true, text: 'Date' }
                    }
                }
            }
        });

        // Top Selling Books Chart
        const ctx2 = document.getElementById('topSellingBooks').getContext('2d');
        const topSellingBooksChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: bookLabels,
                datasets: [{
                    label: 'Top Selling Books',
                    data: bookValues,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Books Sold' }
                    }
                }
            }
        });

        // Sales By Category Chart
        const ctx3 = document.getElementById('salesByCategory').getContext('2d');
        const salesByCategoryChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Sales by Category',
                    data: categoryValues,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Sales' }
                    }
                }
            }
        });

        // Revenue by County Chart
        const ctx4 = document.getElementById('revenueByCountyChart').getContext('2d');
        const revenueByCountyChart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: countyLabels,
                datasets: [{
                    label: 'Total Revenue by County',
                    data: countyRevenue,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Export CSV Logic
        document.getElementById('exportCSV').addEventListener('click', function () {
            const csvData = generateCombinedCSVData();
            exportCSV(csvData, 'dashboard_data.csv');
        });

        function generateCombinedCSVData() {
            const combinedData = [];
            const headers = [
                'Sales Over Time - Date', 'Sales Over Time - Total Sales',
                'Top Selling Books - Book Title', 'Top Selling Books - Quantity Sold',
                'Sales By Category - Category', 'Sales By Category - Total Sales',
                'Shipping Costs - County', 'Shipping Costs - Average Shipping Cost'
            ];
            combinedData.push(headers);

            const maxLength = Math.max(
                salesOverTimeLabels.length,
                bookLabels.length,
                categoryLabels.length,
                countyLabels.length
            );

            for (let i = 0; i < maxLength; i++) {
                const row = [];
                row.push(salesOverTimeLabels[i] || '', salesOverTimeData[i] || '');
                row.push(bookLabels[i] || '', bookValues[i] || '');
                row.push(categoryLabels[i] || '', categoryValues[i] || '');
                row.push(countyLabels[i] || '', countyRevenue[i] || '');
                combinedData.push(row);
            }

            return combinedData;
        }

        function exportCSV(data, filename) {
            let csvContent = '';
            data.forEach(row => {
                csvContent += row.join(',') + '\n';
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
        }

        // Excel Export Logic
        document.getElementById('exportExcel').addEventListener('click', function () {
            const combinedData = generateCombinedExcelData();
            exportExcel(combinedData, 'dashboard_data.xlsx');
        });

        function generateCombinedExcelData() {
            const combinedData = [];
            const headers = [
                'Sales Over Time - Date', 'Sales Over Time - Total Sales',
                'Top Selling Books - Book Title', 'Top Selling Books - Quantity Sold',
                'Sales By Category - Category', 'Sales By Category - Total Sales',
                'Shipping Costs - County', 'Shipping Costs - Average Shipping Cost'
            ];
            combinedData.push(headers);

            const maxLength = Math.max(
                salesOverTimeLabels.length,
                bookLabels.length,
                categoryLabels.length,
                countyLabels.length
            );

            for (let i = 0; i < maxLength; i++) {
                const row = [];
                row.push(salesOverTimeLabels[i] || '', salesOverTimeData[i] || '');
                row.push(bookLabels[i] || '', bookValues[i] || '');
                row.push(categoryLabels[i] || '', categoryValues[i] || '');
                row.push(countyLabels[i] || '', countyRevenue[i] || '');
                combinedData.push(row);
            }

            return combinedData;
        }

        function exportExcel(data, filename) {
            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Dashboard Data');
            XLSX.writeFile(wb, filename);
        }

        // Generate PDF Function
        document.getElementById('downloadPDF').addEventListener('click', function () {
            generatePDF();
        });

        function generatePDF() {
            // Initialize jsPDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('portrait', 'pt', 'a4'); // A4 page size in points (595 x 842)

            // Capture each chart using html2canvas and add to PDF
            const charts = ['salesOverTime', 'topSellingBooks', 'salesByCategory', 'revenueByCountyChart'];

            let yPosition = 20; // Initial Y position for the first chart

            // Using Promise.all to ensure all charts are captured and processed
            Promise.all(
                charts.map((chartId, index) => {
                    return html2canvas(document.getElementById(chartId)).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const imgWidth = 400;  // Chart width in the PDF (adjust if needed)
                        const imgHeight = canvas.height * imgWidth / canvas.width;  // Maintain aspect ratio
                        
                        if (index > 0) {
                            doc.addPage();  // Add new page after the first chart
                        }
                        doc.addImage(imgData, 'PNG', 10, yPosition, imgWidth, imgHeight);
                        yPosition += imgHeight + 20; // Adjust position for next chart
                    });
                })
            ).then(() => {
                // Save the generated PDF
                doc.save('dashboard_data.pdf');
            });
        }
    });


</script>
@endsection
