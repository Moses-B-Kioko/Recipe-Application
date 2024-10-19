@extends('admin.layouts.app')

@section('content')
<h1 style="text-align: center;">Dashboard</h1>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

<script>
    const ctx = document.getElementById('salesOverTime').getContext('2d');
    const salesOverTimeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Sales Over Time',
                data: @json($values),
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

    document.getElementById('salesOverTime').onclick = (event) => {
        const points = salesOverTimeChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
        if (points.length) {
            const firstPoint = points[0];
            const label = salesOverTimeChart.data.labels[firstPoint.index];
            const value = salesOverTimeChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
            alert(`Clicked on ${label}: $${value}`);
        }
    };

    const ctx2 = document.getElementById('topSellingBooks').getContext('2d');
    const topSellingBooksChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($bookLabels),
            datasets: [{
                label: 'Top Selling Books',
                data: @json($bookValues),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });

    const ctx3 = document.getElementById('salesByCategory').getContext('2d');
    const salesByCategoryChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: @json($categoryLabels),
            datasets: [{
                label: 'Sales by Category',
                data: @json($categoryValues),
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxShipping = document.getElementById('shippingCostsChart').getContext('2d');
    const shippingCostsChart = new Chart(ctxShipping, {
        type: 'bar',
        data: {
            labels: @json($countyLabels),
            datasets: [{
                label: 'Average Shipping Cost by County',
                data: @json($countyValues),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Average Shipping Cost (Amount)',
                    }
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
</script>

@endsection

@section('customJs')
<script>
    console.log("hello")
</script>
@endsection
