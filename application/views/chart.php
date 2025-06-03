<!DOCTYPE html>
<html>
<head>
    <title>Invoice and Return Totals by Customer</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-gray: #f5f7fa;
            --dark-gray: #34495e;
            --text-color: #333;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        nav {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            transition: background-color 0.3s ease;
        }
        
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        h2 {
            color: var(--secondary-color);
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 600;
            border-bottom: 2px solid var(--light-gray);
            padding-bottom: 10px;
        }
        
        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }
        
        label {
            font-weight: 500;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: inherit;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            margin-top: 30px;
            padding: 10px 50px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .chart-container {
            position: relative;
            margin-top: 20px;
            height: 400px;
        }
        
        .chart-wrapper {
            margin-bottom: 40px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }
            
            nav a {
                margin-bottom: 5px;
            }
            
            .filter-controls {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .chart-container {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <a href="<?php echo base_url('chart'); ?>">Dashboard</a>
            <a href="<?php echo base_url('dashboard'); ?>">Item</a>
            <a href="<?php echo base_url('invoice'); ?>">Invoices</a>
            <a href="<?php echo base_url('customer'); ?>">Customer</a>
            <a href="<?php echo base_url('unit'); ?>">Unit</a>
            <a href="<?php echo base_url('return'); ?>">Return</a>          
            <a href="<?php echo base_url('invoiceReport'); ?>">Invoice Report</a>
            <a href="<?php echo base_url('returnReport'); ?>">Return Report</a>
            <a style="color:red:" href="<?php echo base_url('login'); ?>">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="card">
            <h2>Invoice and Return Totals by Customer</h2>
            <div class="filter-controls">
                <label>
                    Start Date
                    <input type="date" id="start_date">
                </label>
                <label>
                    End Date
                    <input type="date" id="end_date">
                </label>
                <button onclick="loadChartData()">Apply Filter</button>
            </div>
            <div class="chart-wrapper">
                <div class="chart-container">
                    <canvas id="invoiceChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>Customer Distribution</h2>
            <div class="chart-wrapper">
                <div class="chart-container">
                    <canvas id="customerPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadChartData();
        });

        function loadChartData() {
            const startDate = $('#start_date').val();
            const endDate = $('#end_date').val();

            $.post('Chart_Controller/get_chart_data', { start_date: startDate, end_date: endDate }, function(response) {
                const data = JSON.parse(response);
                const customerNames = data.invoice_totals.map(item => item.customer_name);
                const invoiceTotals = data.invoice_totals.map(item => parseFloat(item.total_amount));
                const returnTotals = data.return_totals.map(item => parseFloat(item.return_total));

                // Get customer percentage data
                const invoiceCustomers = data.customer_percentage.invoice_customers;
                const returnCustomers = data.customer_percentage.return_customers;
                const noInvoiceCustomers = data.customer_percentage.no_invoice_customers;

                // Clear previous charts
                $('#invoiceChart').replaceWith('<canvas id="invoiceChart"></canvas>');
                $('#customerPieChart').replaceWith('<canvas id="customerPieChart"></canvas>');

                // Bar Chart
                new Chart(document.getElementById('invoiceChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: customerNames,
                        datasets: [
                            { label: 'Invoice Total', data: invoiceTotals, backgroundColor: 'rgba(54, 162, 235, 0.7)' },
                            { label: 'Return Total', data: returnTotals, backgroundColor: 'rgba(231, 76, 60, 0.7)' }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { 
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: { 
                                title: { 
                                    display: true, 
                                    text: 'Customer Name',
                                    font: {
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 15,
                                    padding: 20
                                }
                            }
                        }
                    }
                });

                // Pie Chart
                new Chart(document.getElementById('customerPieChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Customers with Invoices', 'Customers with Returns', 'Inactive Customers'],
                        datasets: [{
                            data: [invoiceCustomers, returnCustomers, noInvoiceCustomers],
                            backgroundColor: [
                                'rgba(52, 152, 219, 0.8)',  // Blue
                                'rgba(231, 76, 60, 0.8)',   // Red
                                'rgba(149, 165, 166, 0.8)'  // Grey
                            ],
                            borderColor: [
                                'rgba(52, 152, 219, 1)',
                                'rgba(231, 76, 60, 1)',
                                'rgba(149, 165, 166, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const totalCustomers = data.customer_percentage.total_customers;
                                        const percentage = ((context.raw / totalCustomers) * 100).toFixed(2);
                                        return context.label + ': ' + context.raw + ' (' + percentage + '% of all customers)';
                                    }
                                }
                            },
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20
                                }
                            }
                        }
                    }
                });
            });
        }
    </script>
</body>
</html>