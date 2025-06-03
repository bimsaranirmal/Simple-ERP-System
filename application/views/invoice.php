<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
        
        .view-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
        }
        
        .view-button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 150px;
        }
        
        .view-button:hover {
            background-color: #2980b9;
        }
        
        .view-button.active {
            background-color: #2980b9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .content-wrapper {
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }

        .form-group {
            margin-bottom: 15px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input,
        textarea {
            width: 97%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: inherit;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: inherit;
        }

        .readonly {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        button, .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover, .btn:hover {
            background-color: #45a049;
        }
        
        .form {
            max-width: 100%;
            margin: auto;
            padding: 30px;
            background-color: white;
            border-radius: 5px;
            display: none;
        }
        
        .table-container {
            max-width: 100%;
            margin: auto;
            padding: 30px;
            background-color: white;
            border-radius: 5px;
            display: none;
        }
        
        .show {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: var(--secondary-color);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td a {
            color: #007BFF;
            text-decoration: none;
        }

        table td a:hover {
            text-decoration: underline;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .print-btn {
            background-color: #6c757d;
            width: auto;
        }
        
        .edit-btn {
            background-color: #007BFF;
            width: auto;
        }
        
        .delete-btn {
            background-color: #FF0000;
            width: auto;
        }
        
        .add-btn {
            background-color: #007BFF;
            margin-top: 10px;
            width: auto;
            display: block;
        }
        
        .save-btn {
            margin-top: 20px;
            width: 100%;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        
        .item-row {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
    </style>
    <script>
        const itemsData = <?php echo json_encode($items); ?>;
        const unitsData = <?php echo json_encode($units); ?>;

        function updateItemDetails(selectElement) {
            const selectedItemId = selectElement.value;
            const selectedItem = itemsData.find(item => item.id == selectedItemId);

            const row = selectElement.closest('.item-row');
            const priceInput = row.querySelector('.item-price');
            const descriptionTextarea = row.querySelector('.item-description');

            if (selectedItem) {
                priceInput.value = selectedItem.item_price;
                descriptionTextarea.value = selectedItem.item_description;
                updateTotal(row.querySelector('.quantity'));
            } else {
                priceInput.value = '';
                descriptionTextarea.value = '';
                updateTotal(row.querySelector('.quantity'));
            }
        }

        function updateCustomerDetails(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const name = selectedOption.getAttribute('data-name') || '';
            const address = selectedOption.getAttribute('data-address') || '';
            document.getElementById('customer-address').value = address; // Update the address field
        }

        function updateTotal(quantityInput) {
            const row = quantityInput.closest('.item-row');
            const priceInput = row.querySelector('.item-price');
            const totalInput = row.querySelector('.total');

            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseFloat(quantityInput.value) || 0;

            totalInput.value = (price * quantity).toFixed(2);
        }
    </script>
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
        <h1>Invoice Management</h1>
        
        <div class="view-buttons">
            <button id="formButton" class="view-button active">Create Invoice</button>
            <button id="tableButton" class="view-button">View Invoices</button>
        </div>
        
        <div class="content-wrapper">
            <!-- Create Invoice Form -->
            <div id="formContainer" class="form show">
                <form method="POST" action="<?php echo base_url('invoice/save'); ?>">
                    <div class="form-group">
                        <label for="customer-select">Select Customer:</label>
                        <select id="customer-select" name="customer_id" onchange="updateCustomerDetails(this)" required>
                            <option value="">-- Select a Customer --</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?php echo $customer->id; ?>" data-name="<?php echo $customer->customer_name; ?>"
                                    data-address="<?php echo $customer->address; ?>">
                                    <?php echo $customer->customer_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="customer-address">Customer Address:</label>
                        <textarea id="customer-address" class="readonly" readonly style="resize: none;"></textarea>
                    </div>
                    
                    <div id="items-container">
                        <div class="form-group item-row">
                            <div style="display: flex; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 150px;">
                                    <label for="item-select">Select Item:</label>
                                    <select name="item_id[]" class="item-select" onchange="updateItemDetails(this)" required>
                                        <option value="">-- Select an Item --</option>
                                        <?php foreach ($items as $item): ?>
                                            <option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div style="flex: 2; min-width: 200px;">
                                    <label for="item-description">Item Description:</label>
                                    <input type="text" name="item_description[]" class="item-description readonly" readonly>
                                </div>

                                <div style="flex: 1; min-width: 100px;">
                                    <label for="item-price">Item Price:</label>
                                    <input type="text" name="item_price[]" class="item-price readonly" readonly style="text-align: right;">
                                </div>

                                <div style="flex: 1; min-width: 100px;">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" name="quantity[]" class="quantity" min="0.5" value="1" style="text-align: right;"
                                        onchange="updateTotal(this)" required>
                                </div>

                                <div style="flex: 1; min-width: 100px;">
                                    <label for="total">Amount:</label>
                                    <input type="text" name="total[]" class="total readonly" readonly style="text-align: right;">
                                </div>

                                <div style="flex: 1; min-width: 150px;">
                                    <label for="unit-select">Select Unit:</label>
                                    <select name="unit_id[]" class="unit-select" required>
                                        <option value="">-- Select a Unit --</option>
                                        <?php foreach ($units as $unit): ?>
                                            <option value="<?php echo $unit->id; ?>"><?php echo $unit->unit_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div style="min-width: 100px; display: flex; align-items: flex-end;">
                                    <button type="button" class="delete-btn" onclick="removeItem(this)" style="margin-top: 20px;">
                                        <i class="bi bi-x-circle"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-item" class="add-btn">
                        <i class="bi bi-plus-circle"></i> Add Item
                    </button>

                    <button type="submit" class="save-btn">Save Invoice</button>
                </form>
            </div>
            
            <!-- Invoices Table -->
            <div id="tableContainer" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Item Name</th>
                            <th>Item Description</th>
                            <th>Item Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Unit Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($invoices)): ?>
                            <?php foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td><?php echo $invoice->invoice_id; ?></td>
                                    <td><?php echo $invoice->customer_name; ?></td>
                                    <td><?php echo $invoice->customer_address; ?></td>
                                    <td><?php echo $invoice->item_name; ?></td>
                                    <td><?php echo $invoice->item_description; ?></td>
                                    <td style="text-align: right;"><?php echo $invoice->item_price; ?></td>
                                    <td style="text-align: right;"><?php echo $invoice->quantity; ?></td>
                                    <td style="text-align: right;"><?php echo $invoice->total; ?></td>
                                    <td><?php echo $invoice->unit_name; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($invoice->created_at)); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="print-btn" onclick="printInvoice('<?php echo $invoice->invoice_id; ?>')">
                                                <i class="bi bi-printer"></i> Print
                                            </button>
                                            <button type="button" class="edit-btn" onclick="editInvoice('<?php echo $invoice->invoice_id; ?>')">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button type="button" class="delete-btn" onclick="deleteInvoice('<?php echo $invoice->invoice_id; ?>')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="no-data">No invoices found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        const formButton = document.getElementById('formButton');
        const tableButton = document.getElementById('tableButton');
        const formContainer = document.getElementById('formContainer');
        const tableContainer = document.getElementById('tableContainer');
        
        // Add event listeners
        formButton.addEventListener('click', function() {
            formContainer.classList.add('show');
            tableContainer.classList.remove('show');
            formButton.classList.add('active');
            tableButton.classList.remove('active');
        });
        
        tableButton.addEventListener('click', function() {
            tableContainer.classList.add('show');
            formContainer.classList.remove('show');
            tableButton.classList.add('active');
            formButton.classList.remove('active');
        });

        function editInvoice(invoice_id) {
            window.location.href = '<?php echo base_url("invoice/edit/"); ?>' + invoice_id;
        }

        function deleteInvoice(invoice_id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                window.location.href = '<?php echo base_url("invoice/delete/"); ?>' + invoice_id;
            }
        }

        document.getElementById('add-item').addEventListener('click', function () {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'item-row');

            newRow.innerHTML = `
            <div style="display: flex; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 150px;">
                    <label for="item-select">Select Item:</label>
                    <select name="item_id[]" class="item-select" onchange="updateItemDetails(this)" required>
                        <option value="">-- Select an Item --</option>
                        <?php foreach ($items as $item): ?>
                            <option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="flex: 2; min-width: 200px;">
                    <label for="item-description">Item Description:</label>
                    <input type="text" name="item_description[]" class="item-description readonly" readonly>
                </div>

                <div style="flex: 1; min-width: 100px;">
                    <label for="item-price">Item Price:</label>
                    <input type="text" name="item_price[]" class="item-price readonly" readonly style="text-align: right;">
                </div>

                <div style="flex: 1; min-width: 100px;">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity[]" class="quantity" min="0.5" value="1" style="text-align: right;"
                        onchange="updateTotal(this)" required>
                </div>

                <div style="flex: 1; min-width: 100px;">
                    <label for="total">Amount:</label>
                    <input type="text" name="total[]" class="total readonly" readonly style="text-align: right;">
                </div>

                <div style="flex: 1; min-width: 150px;">
                    <label for="unit-select">Select Unit:</label>
                    <select name="unit_id[]" class="unit-select" required>
                        <option value="">-- Select a Unit --</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit->id; ?>"><?php echo $unit->unit_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="min-width: 100px; display: flex; align-items: flex-end;">
                    <button type="button" class="delete-btn" onclick="removeItem(this)" style="margin-top: 20px;">
                        <i class="bi bi-x-circle"></i> Remove
                    </button>
                </div>
            </div>
            `;
            container.appendChild(newRow);
        });

        function removeItem(button) {
            const row = button.closest('.item-row');
            row.remove();
        }

        function printInvoice(invoiceId) {
            const invoiceRow = Array.from(document.querySelectorAll('tbody tr')).find(row => {
                return row.querySelector('td:first-child')?.textContent.trim() == invoiceId;
            });

            if (!invoiceRow) {
                alert('Invoice details not found.');
                return;
            }

            // Fetch customer name and address from the invoice row
            const customerName = invoiceRow.querySelector('td:nth-child(2)')?.textContent.trim() || '';
            const customerAddress = invoiceRow.querySelector('td:nth-child(3)')?.textContent.trim() || '';

            // Prepare the print content
            let printContent = `
            <div style="font-family: Arial, sans-serif; margin: 20px;">
                <h1 style="text-align: center;">INVOICE</h1>
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <div>
                        <p><strong>Customer Name:</strong> ${customerName}</p>
                        <p><strong>Address:</strong> ${customerAddress}</p>
                    </div>
                    <div>
                        <p><strong>Invoice No:</strong> INV${invoiceId.padStart(5, '0')}</p>
                        <p><strong>Date:</strong> ${new Date().toISOString().split('T')[0]}</p>
                    </div>
                </div>
                <table border="1" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let totalQty = 0;
            let totalAmount = 0;

            const invoiceRows = Array.from(document.querySelectorAll('tbody tr')).filter(row => {
                return row.querySelector('td:first-child')?.textContent.trim() == invoiceId;
            });

            invoiceRows.forEach(row => {
                const itemName = row.querySelector('td:nth-child(4)')?.textContent.trim() || '';
                const description = row.querySelector('td:nth-child(5)')?.textContent.trim() || '';
                const unit = row.querySelector('td:nth-child(9)')?.textContent.trim() || '';
                const price = parseFloat(row.querySelector('td:nth-child(6)')?.textContent.trim() || 0).toFixed(2);
                const qty = parseFloat(row.querySelector('td:nth-child(7)')?.textContent.trim() || 0).toFixed(2);
                const amount = parseFloat(row.querySelector('td:nth-child(8)')?.textContent.trim() || 0).toFixed(2);

                totalQty += parseFloat(qty);
                totalAmount += parseFloat(amount);

                printContent += `
                <tr>
                    <td>${itemName}</td>
                    <td>${description}</td>
                    <td>${unit}</td>
                    <td style="text-align: right;">${price}</td>
                    <td style="text-align: right;">${qty}</td>
                    <td style="text-align: right;">${amount}</td>
                </tr>
                `;
            });

            printContent += `
                    </tbody>
                </table>
                <div style="display: flex; justify-content: space-between; font-weight: bold;">
                    <p>Total QTY: ${totalQty.toFixed(2)}</p>
                    <p>Total Amount: ${totalAmount.toFixed(2)}</p>
                </div>
            </div>
            `;

            // Open a new window for printing
            const printWindow = window.open('', '_blank', 'width=800,height=600');

            printWindow.document.write(`
            <html>
            <head>
                <title>Print Invoice</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ccc;
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    h1 {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    p {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
            `);

            printWindow.document.close();
            printWindow.print();
        }
    </script>

</body>

</html>