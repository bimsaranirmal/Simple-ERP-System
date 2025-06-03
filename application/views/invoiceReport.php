<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Reports</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- DatePicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
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
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }

        .btn-icon {
            margin-right: 5px;
        }

        .report-options {
            margin-bottom: 20px;
        }

        .datepicker {
            z-index: 1600 !important;
            /* To ensure datepicker appears above other elements */
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
    <div class="container-fluid mt-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Invoice Reports</h1>
        </div>

        <!-- Report Generator Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Generate Invoice Reports</h5>
            </div>
            <div class="card-body">
                <!-- Report Options Form -->
                <div class="report-options">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                                    placeholder="Select start date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                                    placeholder="Select end date">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id">
                                    <option value="">All Customers</option>
                                    <?php
                                    // Load Customer model to get customer list
                                    $CI =& get_instance();
                                    $CI->load->model('Customer_Model');
                                    $customers = $CI->Customer_Model->get_all_customers();

                                    foreach ($customers as $customer) {
                                        echo '<option value="' . $customer->id . '">' . $customer->customer_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="report_type">Report Type</label>
                                <select class="form-control" id="report_type" name="report_type">
                                    <option value="excel">Excel Report</option>
                                    <option value="pdf">PDF Report</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="generateReport()">
                                <i class="fas fa-file-export btn-icon"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice List Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Invoice List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="invoiceTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Load Invoice model to get invoice list
                            $CI =& get_instance();
                            $CI->load->model('Invoice_Model');
                            $invoices = $CI->Invoice_Model->get_all_invoices_copy();

                            // Process invoices to group by invoice_id
                            $grouped_invoices = [];
                            foreach ($invoices as $invoice) {
                                if (!isset($grouped_invoices[$invoice->invoice_id])) {
                                    $grouped_invoices[$invoice->invoice_id] = [
                                        'invoice_id' => $invoice->invoice_id,
                                        'created_at' => $invoice->created_at,
                                        'customer_name' => $invoice->customer_name,
                                        'items' => [],
                                        'total' => 0
                                    ];
                                }

                                $grouped_invoices[$invoice->invoice_id]['items'][] = $invoice->item_name;
                                $grouped_invoices[$invoice->invoice_id]['total'] += $invoice->total;
                            }

                            foreach ($grouped_invoices as $invoice) {
                                echo '<tr>';
                                echo '<td>' . $invoice['invoice_id'] . '</td>';
                                echo '<td>' . date('Y-m-d', strtotime($invoice['created_at'])) . '</td>';
                                echo '<td>' . $invoice['customer_name'] . '</td>';
                                echo '<td>' . implode(', ', array_slice($invoice['items'], 0, 3)) .
                                    (count($invoice['items']) > 3 ? '...' : '') . '</td>';
                                echo '<td style="text-align: right;">' . number_format($invoice['total'], 2) . '</td>';
                                echo '<td>
                                        <a href="' . base_url('invoiceReport/print_invoice/' . $invoice['invoice_id']) . '" 
                                           class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                        <a href="' . base_url('invoice/edit/' . $invoice['invoice_id']) . '" 
                                        class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>                                     
                                        </td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DatePicker JS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <script>

        function editInvoice(invoice_id) {
            window.location.href = '<?php echo base_url("invoice/edit/"); ?>' + invoice_id;
        }

        $(document).ready(function () {
            // Initialize DataTable
            $('#invoiceTable').DataTable({
                "order": [[0, "desc"]],
                "pageLength": 25
            });

            // Initialize DatePicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });

        function generateReport() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var customer_id = $('#customer_id').val();
            var report_type = $('#report_type').val();

            // Create a form to submit
            var form = document.createElement('form');
            form.method = 'POST';

            if (report_type === 'excel') {
                form.action = '<?php echo base_url('invoiceReport/generate_csv'); ?>';
            } else {
                form.action = '<?php echo base_url('invoiceReport/generate_pdf_simple'); ?>';
            }

            // Add hidden fields
            var startDateInput = document.createElement('input');
            startDateInput.type = 'hidden';
            startDateInput.name = 'start_date';
            startDateInput.value = start_date;
            form.appendChild(startDateInput);

            var endDateInput = document.createElement('input');
            endDateInput.type = 'hidden';
            endDateInput.name = 'end_date';
            endDateInput.value = end_date;
            form.appendChild(endDateInput);

            var customerIdInput = document.createElement('input');
            customerIdInput.type = 'hidden';
            customerIdInput.name = 'customer_id';
            customerIdInput.value = customer_id;
            form.appendChild(customerIdInput);

            // Submit the form
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>
</body>

</html>