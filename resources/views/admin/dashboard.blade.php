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
                     <p class="card-text">{{ $bestCategory->name }}</p> <!--Display only the category name -->
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
        <div style="flex: 1; margin-left: 10px;">
            <canvas id="shippingCostsChart" width="400" height="200"></canvas>
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
    // Chart Initialization
    document.addEventListener('DOMContentLoaded', function() {
        const salesOverTimeLabels = @json($labels);
        const salesOverTimeData = @json($values);
        const bookLabels = @json($bookLabels);
        const bookValues = @json($bookValues);
        const categoryLabels = @json($categoryLabels);
        const categoryValues = @json($categoryValues);
        const countyLabels = @json($countyLabels);
        const countyValues = @json($countyValues);

        // Sales Over Time Chart
        const ctx = document.getElementById('salesOverTime').getContext('2d');
        const salesOverTimeChart = new Chart(ctx, {
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
                        title: {
                            display: true,
                            text: 'Total Sales (Grand Total)',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                        },
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
                        title: {
                            display: true,
                            text: 'Total Books Sold',
                        },
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
                        title: {
                            display: true,
                            text: 'Total Sales',
                        },
                    }
                }
            }
        });

        // Shipping Costs Chart
        const ctxShipping = document.getElementById('shippingCostsChart').getContext('2d');
        const shippingCostsChart = new Chart(ctxShipping, {
            type: 'bar',
            data: {
                labels: countyLabels,
                datasets: [{
                    label: 'Average Shipping Cost by County',
                    data: countyValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Average Shipping Cost (Amount)',
                        },
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'County',
                        }
                    }
                }
            }
        });

        /* Export CSV Logic
        document.getElementById('exportCSV').addEventListener('click', function () {
            const headers = ['Label', 'Value'];
            const csvData = salesOverTimeLabels.map((label, index) => [label, salesOverTimeData[index]]);
            const csvContent = convertToCSV(csvData, headers);
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'sales_data.csv';
            a.click();
            URL.revokeObjectURL(url);
        }); */

        // Export Excel Logic
        // Event listener for the Export CSV button
document.getElementById('exportCSV').addEventListener('click', function () {
    const csvData = generateCombinedCSVData();
    exportCSV(csvData, 'dashboard_data.csv');
});

// Function to Generate Combined CSV Data
function generateCombinedCSVData() {
    // Create an array to hold the combined data
    const combinedData = [];

    // Prepare headers
    const headers = [
        'Sales Over Time - Date', 'Sales Over Time - Total Sales',
        'Top Selling Books - Book Title', 'Top Selling Books - Quantity Sold',
        'Sales By Category - Category', 'Sales By Category - Total Sales',
        'Shipping Costs - County', 'Shipping Costs - Average Shipping Cost'
    ];

    // Push headers to the combined data
    combinedData.push(headers);

    // Find the maximum length of the data arrays to iterate through
    const maxLength = Math.max(
        salesOverTimeLabels.length,
        bookLabels.length,
        categoryLabels.length,
        countyLabels.length
    );

    // Fill combined data row by row
    for (let i = 0; i < maxLength; i++) {
        const row = [];

        // Sales Over Time Data
        row.push(salesOverTimeLabels[i] || '', salesOverTimeData[i] || '');

        // Top Selling Books Data
        row.push(bookLabels[i] || '', bookValues[i] || '');

        // Sales By Category Data
        row.push(categoryLabels[i] || '', categoryValues[i] || '');

        // Shipping Costs Data
        row.push(countyLabels[i] || '', countyValues[i] || '');

        combinedData.push(row);
    }

    return combinedData;
}

// Function to export data to CSV
function exportCSV(data, filename) {
    const csvContent = data.map(row => row.join(',')).join('\n'); // Convert data to CSV format
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename; // Set the filename for download
    document.body.appendChild(a); // Append to the body
    a.click(); // Programmatically click the link to trigger the download
    document.body.removeChild(a); // Remove the link after download
    URL.revokeObjectURL(url); // Revoke the object URL
}



        // Export Excel Logic
       /* document.getElementById('exportExcel').addEventListener('click', function () {
            const excelData = salesOverTimeLabels.map((label, index) => ({
                Date: label,
                'Total Sales': salesOverTimeData[index]
            }));
            exportToExcel(excelData, 'sales_data.xlsx');
        }); */
        // Export Excel Logic
       // Export Excel Logic
document.getElementById('exportExcel').addEventListener('click', function () {
    const excelData = generateCombinedExcelData();
    exportToExcel(excelData, 'dashboard_data.xlsx');
});

// Function to Generate Combined Excel Data
function generateCombinedExcelData() {
    // Create an array to hold the combined data
    const combinedData = [];

    // Prepare headers
    const headers = [
        'Sales Over Time - Date', 
        'Sales Over Time - Total Sales',
        'Top Selling Books - Book Title', 
        'Top Selling Books - Quantity Sold',
        'Sales By Category - Category', 
        'Sales By Category - Total Sales',
        'Shipping Costs - County', 
        'Shipping Costs - Average Shipping Cost'
    ];

    // Push headers to the combined data
    combinedData.push(headers);

    // Find the maximum length of the data arrays to iterate through
    const maxLength = Math.max(
        salesOverTimeLabels.length,
        bookLabels.length,
        categoryLabels.length,
        countyLabels.length
    );

    // Fill combined data row by row
    for (let i = 0; i < maxLength; i++) {
        const row = [];

        // Sales Over Time Data
        row.push(salesOverTimeLabels[i] || '', salesOverTimeData[i] || '');

        // Top Selling Books Data
        row.push(bookLabels[i] || '', bookValues[i] || '');

        // Sales By Category Data
        row.push(categoryLabels[i] || '', categoryValues[i] || '');

        // Shipping Costs Data
        row.push(countyLabels[i] || '', countyValues[i] || '');

        combinedData.push(row);
    }

    // Return combined data for Excel export
    return combinedData; // Include headers and data
}

// Export to Excel Function
function exportToExcel(data, filename) {
    // Create a new workbook
    const workbook = XLSX.utils.book_new();

    // Convert the data into a worksheet
    const worksheet = XLSX.utils.aoa_to_sheet(data);
    
    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Combined Data');

    // Save the workbook
    XLSX.writeFile(workbook, filename);
}


        // Download PDF Logic
        document.getElementById('downloadPDF').addEventListener('click', function () {
            generatePDF();
        });
    });

    /* CSV Conversion Function
    function convertToCSV(data, headers) {
        const csvRows = [headers.join(',')];
        data.forEach(row => csvRows.push(row.join(',')));
        return csvRows.join('\n');
    } */

    /* Export to Excel Function
    function exportToExcel(data, filename) {
        const worksheet = XLSX.utils.json_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
        XLSX.writeFile(workbook, filename);
    } */

    // Generate PDF Function
    function generatePDF() {
        // Initialize jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('portrait', 'pt', 'a4'); // A4 page size in points (595 x 842)

        // Capture each chart using html2canvas and add to PDF
        const charts = ['salesOverTime', 'topSellingBooks', 'salesByCategory', 'shippingCostsChart'];

        let yPosition = 20; // Initial Y position for the first chart

        // Using Promise.all to ensure all charts are captured and processed
        Promise.all(
            charts.map((chartId, index) => {
                return html2canvas(document.getElementById(chartId)).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = 400;  // Chart width in the PDF (adjust if needed)
                    const imgHeight = canvas.height * imgWidth / canvas.width;  // Maintain aspect ratio
                    
                    if (yPosition + imgHeight > 800) { 
                        // If the next chart would overflow the page, create a new page
                        doc.addPage();
                        yPosition = 20; // Reset y position for the new page
                    }

                    // Add image to the PDF at the current position
                    doc.addImage(imgData, 'PNG', 40, yPosition, imgWidth, imgHeight);
                    
                    yPosition += imgHeight + 20; // Update Y position for the next chart, adding a margin
                });
            })
        ).then(() => {
            // Save the PDF after all charts are added
            doc.save('dashboard_reports.pdf');
        });
    }
</script>
@endsection
