
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Management</title>
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
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .readonly {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        button {
            width: 100%;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
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

        .section-title {
            color: var(--secondary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
        }

        .item-row {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .remove-item {
            background-color: var(--accent-color);
            transition: background-color 0.3s ease;
        }

        .remove-item:hover {
            background-color: #c0392b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        
        table th,
        table td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }
        
        table th {
            background-color: var(--secondary-color);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table tr:hover {
            background-color: #f1f1f1;
        }
        
        table td a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        table td a:hover {
            text-decoration: underline;
        }
        
        table td button {
            width: auto;
            padding: 6px 12px;
            margin: 0 5px;
            border-radius: 4px;
            font-size: 13px;
        }
        
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
            padding: 20px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
        }
        
        .action-buttons button {
            width: auto;
        }
        
        .load-button {
            background-color: var(--primary-color);
            transition: background-color 0.3s ease;
        }
        
        .load-button:hover {
            background-color: #2980b9;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 25px;
            border: 1px solid #888;
            width: 70%;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .modal-table th,
        .modal-table td {
            color: var(--text-color);
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .modal-table th {
            background-color: #f4f4f4;
            font-weight: 600;
        }

        .view-items-button {
            background-color: var(--primary-color);
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-items-button:hover {
            background-color: #2980b9;
        }

        .add-item-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            width: auto;
        }

        .add-item-button:hover {
            background-color: #45a049;
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
            } else {
                priceInput.value = '';
                descriptionTextarea.value = '';
            }
            
            updateTotal(row.querySelector('.quantity'));
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
        <h1>Return Management</h1>
        
        <div class="view-buttons">
            <button id="formButton" class="view-button active">Create Return</button>
            <button id="tableButton" class="view-button">View Returns</button>
        </div>
        
        <div class="content-wrapper">
            <!-- Create Return Form -->
            <div id="formContainer" class="form show">
                <form method="POST" action="<?php echo base_url('return/save'); ?>">
                    <div class="section-title">Customer Information</div>
                    
                    <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                        <div style="flex: 3;">
                            <label for="customer-select">Select Customer:</label>
                            <select id="customer-select" name="customer_id" required>
                                <option value="">-- Select a Customer --</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?php echo $customer->id; ?>"><?php echo $customer->customer_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="flex: 1; margin-top: 25px;">
                            <button type="button" id="load-invoices" class="load-button">
                                Load Invoices
                            </button>
                        </div>
                    </div>

                    <input type="hidden" id="selected-invoice-id" name="invoice_id" value="">

                    <div id="invoice-modal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2 class="section-title">Customer's Invoices</h2>
                            <table id="modal-invoice-table" class="modal-table">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div id="invoice-items" style="margin-top: 20px;">
                                <h3 class="section-title">Invoice Items</h3>
                                <table class="modal-table">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice-items-table"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="section-title">Return Items</div>
                    <div id="items-container">
                        <!-- Items will be added here -->
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <button type="button" id="add-item" style="flex: 1; background-color: var(--primary-color);">
                            Add Item
                        </button>
                        <button type="submit" style="flex: 1; background-color: #28a745;">
                            Save Return
                        </button>
                    </div>
                </form>
            </div>

            <!-- Returns Table -->
            <div id="tableContainer" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Return ID</th>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Customer Address</th>
                            <th>Item</th>
                            <th>Item Description</th>
                            <th>Item Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Unit</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($returns)): ?>
                            <?php foreach ($returns as $return): ?>
                                <tr>
                                    <td><?php echo $return->return_id; ?></td>
                                    <td><?php echo $return->invoice_id; ?></td>
                                    <td><?php echo $return->customer_name; ?></td>
                                    <td><?php echo $return->customer_address; ?></td>
                                    <td><?php echo $return->item_name; ?></td>
                                    <td><?php echo $return->item_description; ?></td>
                                    <td style="text-align: right;"><?php echo $return->price; ?></td>
                                    <td style="text-align: right;"><?php echo $return->quantity; ?></td>
                                    <td style="text-align: right;"><?php echo $return->total; ?></td>
                                    <td><?php echo $return->unit_name; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($return->created_at)); ?></td>
                                    <td class="action-buttons">
                                        <button  onclick="printInvoice('<?php echo $return->return_id; ?>')"><i class="bi bi-printer"></i> Print</button>
                                        <button style="background-color: var(--primary-color);" onclick="editReturn('<?php echo $return->return_id; ?>')">Edit</button>
                                        <button style="background-color: var(--accent-color);" onclick="deleteReturn('<?php echo $return->return_id; ?>')">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="no-data">No return records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle between Add Return and View Returns
        const formButton = document.getElementById('formButton');
        const tableButton = document.getElementById('tableButton');
        const formContainer = document.getElementById('formContainer');
        const tableContainer = document.getElementById('tableContainer');
        
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
        function editReturn(returnId) {
            window.location.href = '<?php echo base_url("return/edit/"); ?>' + returnId;
        }

        function deleteReturn(returnId) {
            if (confirm('Are you sure you want to delete this return?')) {
                window.location.href = '<?php echo base_url("return/delete/"); ?>' + returnId;
            }
        }

        function printReturn(returnId) {
            window.location.href = '<?php echo base_url("return/print/"); ?>' + returnId;
        }



        document.getElementById('add-item').addEventListener('click', function () {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'item-row');
            newRow.style.display = 'flex';
            newRow.style.alignItems = 'center';
            newRow.style.gap = '20px';

            newRow.innerHTML = `
            <div style="flex: 1;">
                            <label for="item-select">Select Item:</label>
                            <select name="item_id[]" class="item-select" onchange="updateItemDetails(this)" required>
                                <option value="">-- Select an Item --</option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div style="flex: 2;">
                            <label for="item-description">Item Description:</label>
                            <input type="text" name="item_description[]" class="item-description readonly" readonly
                                style="resize: none;">
                        </div>

                        <div style="flex: 1;">
                            <label for="item-price">Item Price:</label>
                            <input type="text" name="item_price[]" class="item-price readonly" readonly
                                style="text-align: right;">
                        </div>

                        <div style="flex: 1;">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity[]" class="quantity"  value="1"
                                onchange="updateTotal(this)" required>
                        </div>

                        <div style="flex: 1;">
                            <label for="total">Amount:</label>
                            <input type="text" name="total[]" class="total readonly" readonly
                                style="text-align: right;">
                        </div>



                        <div style="flex: 1;">
                            <label for="unit-select">Select Unit:</label>
                            <select name="unit_id[]" class="unit-select" required>
                                <option value="">-- Select a Unit --</option>
                                <?php foreach ($units as $unit): ?>
                                    <option value="<?php echo $unit->id; ?>"><?php echo $unit->unit_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
            <div>
                <button type="button" class="remove-item" onclick="removeItem(this)">Remove</button>
            </div>
        `;
            container.appendChild(newRow);
        });

        function removeItem(button) {
            const row = button.closest('.item-row');
            row.remove();
        }

        

        function updateItemDetails(selectElement) {
            const selectedItemId = selectElement.value;
            const selectedItem = itemsData.find(item => item.id == selectedItemId);

            const row = selectElement.closest('.item-row');
            const priceInput = row.querySelector('.item-price');
            const descriptionTextarea = row.querySelector('.item-description');

            if (selectedItem) {
                priceInput.value = selectedItem.item_price;
                descriptionTextarea.value = selectedItem.item_description;
            } else {
                priceInput.value = '';
                descriptionTextarea.value = '';
            }
        }



        const modal = document.getElementById("invoice-modal");
        const span = document.getElementsByClassName("close")[0];

        // Open Modal
        function openModal() {
            modal.style.display = "block";
        }

        // Close Modal
        span.onclick = function () {
            modal.style.display = "none";
            document.getElementById("invoice-items").innerHTML = "";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.getElementById("invoice-items").innerHTML = "";
            }
        }

        // Load Invoices with Modal
        document.getElementById('load-invoices').addEventListener('click', function () {
            const customerId = document.getElementById('customer-select').value;

            if (!customerId) {
                alert('Please select a customer.');
                return;
            }

            fetch('<?php echo base_url("return/get_invoices_by_customer"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `customer_id=${customerId}`,
            })
                .then(response => response.json())
                .then(data => {
                    const modalTableBody = document.querySelector('#modal-invoice-table tbody');
                    modalTableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(invoice => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${invoice.invoice_id}</td>
                        <td>${parseFloat(invoice.total_amount).toFixed(2)}</td>
                        <td>
                            <button class="view-items-button" onclick="viewInvoiceItems(${invoice.invoice_id})">View Items</button>
                        </td>
                    `;
                            modalTableBody.appendChild(row);
                        });
                    } else {
                        modalTableBody.innerHTML = '<tr><td colspan="3" style="text-align: center;">No invoices found.</td></tr>';
                    }

                    openModal();
                })
                .catch(error => {
                    console.error('Error fetching invoices:', error);
                    alert('An error occurred while fetching invoices. Please try again.');
                });
        });

        // View Invoice Items
        function viewInvoiceItems(invoiceId) {

            event.preventDefault();
            // Check if the hidden input field for invoice ID exists
            let hiddenInvoiceField = document.getElementById('selected-invoice-id');

            // If not, create it and append to the form
            if (!hiddenInvoiceField) {
                hiddenInvoiceField = document.createElement('input');
                hiddenInvoiceField.type = 'hidden';
                hiddenInvoiceField.id = 'selected-invoice-id';
                hiddenInvoiceField.name = 'invoice_id';
                document.querySelector('.form').appendChild(hiddenInvoiceField);
                console.log("Hidden invoice ID field created.");
            }

            // Set the invoice ID to the hidden field
            hiddenInvoiceField.value = invoiceId;
            console.log("Invoice ID set to:", invoiceId);

            fetch('<?php echo base_url("return/get_invoice_items"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `invoice_id=${invoiceId}`,
            })
                .then(response => response.json())
                .then(items => {
                    const itemsTableBody = document.getElementById('invoice-items-table');
                    itemsTableBody.innerHTML = ''; // Clear existing rows

                    if (items.length > 0) {
                        items.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                    <td>${item.item_name}</td>
                    <td>${item.item_description}</td>
                    <td>${parseFloat(item.quantity).toFixed(2)}</td>
                    <td>${parseFloat(item.item_price).toFixed(2)}</td>
                    <td>${parseFloat(item.total).toFixed(2)}</td>
                    <td>${item.unit_name}</td>
                    <td>
                        <button type="button"  class="add-item-button" onclick="addItemToForm('${item.item_name}', '${item.item_description}', ${item.quantity}, ${item.item_price}, ${item.total}, '${item.unit_name}')">
                            Add Item
                        </button>
                    </td>
                `;
                            itemsTableBody.appendChild(row);
                        });
                    } else {
                        itemsTableBody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No items found for this invoice.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching invoice items:', error);
                    alert('An error occurred while fetching items. Please try again.');
                });
        }

        function addItemToForm(itemName, itemDescription, quantity, price, total, unitName) {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'item-row');
            newRow.style.display = 'flex';
            newRow.style.alignItems = 'center';
            newRow.style.gap = '20px';

            let itemOptions = '<option value="">-- Select an Item --</option>';
            itemsData.forEach(item => {
                const isSelected = item.item_name === itemName ? 'selected' : '';
                itemOptions += `<option value="${item.id}" ${isSelected}>${item.item_name}</option>`;
            });

            let unitOptions = '<option value="">-- Select Unit --</option>';
            unitsData.forEach(unit => {
                const isUnitSelected = unit.unit_name === unitName ? 'selected' : '';
                unitOptions += `<option value="${unit.id}" ${isUnitSelected}>${unit.unit_name}</option>`;
            });

            newRow.innerHTML = `
        <div style="flex: 1;">
            <label for="item-select">Select Item:</label>
            <select name="item_id[]" class="item-select" onchange="updateItemDetails(this)" required>
                ${itemOptions}
            </select>
        </div>
        <div style="flex: 2;">
            <label for="item-description">Item Description:</label>
            <input type="text" name="item_description[]" class="item-description readonly" value="${itemDescription}" readonly>
        </div>
        <div style="flex: 1;">
            <label for="item-price">Item Price:</label>
            <input type="text" name="item_price[]" class="item-price readonly" style="text-align: right;" value="${price}" readonly>
        </div>
        <div style="flex: 1;">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity[]" class="quantity"  style="text-align: right;" value="${quantity}" onchange="updateTotal(this)" required>
        </div>
        <div style="flex: 1;">
            <label for="total">Amount:</label>
            <input type="text" name="total[]" class="total readonly" style="text-align: right;" value="${total}" readonly>
        </div>
        <div style="flex: 1;">
            <label for="unit-select">Select Unit:</label>
            <select name="unit_id[]" class="unit-select" required>
                ${unitOptions}
            </select>
        </div>
        <div>
            <button type="button" class="remove-item" onclick="removeItem(this)" style="background-color: #FF0000; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Remove</button>
        </div>
    `;
            container.appendChild(newRow);
        }

        function updateTotal(quantityInput) {
            const row = quantityInput.closest('.item-row');
            const priceInput = row.querySelector('.item-price');
            const totalInput = row.querySelector('.total');

            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseFloat(quantityInput.value) || 0;

            const total = (price * quantity).toFixed(2);
            totalInput.value = total;

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;

            document.querySelectorAll('.total').forEach(totalField => {
                const amount = parseFloat(totalField.value) || 0;
                grandTotal += amount;
            });

            const grandTotalField = document.getElementById('grand-total');
            if (grandTotalField) {
                grandTotalField.textContent = `Grand Total: ${grandTotal.toFixed(2)}`;
            }
        }

        function printInvoice(invoiceId) {
            const invoiceRow = Array.from(document.querySelectorAll('tbody tr')).find(row => {
                return row.querySelector('td:first-child')?.textContent.trim() == invoiceId;
            });

            if (!invoiceRow) {
                alert('Invoice details not found.');
                return;
            }

            const customerName = invoiceRow.querySelector('td:nth-child(3)')?.textContent.trim() || '';
            const customerAddress = invoiceRow.querySelector('td:nth-child(4)')?.textContent.trim() || '';

            let printContent = `
            <div style="font-family: Arial, sans-serif; margin: 20px;">
                <h1 style="text-align: center;">RETURN INVOICE</h1>
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <div>
                        <p><strong>Customer Name:</strong> ${customerName}</p>
                        <p><strong>Address:</strong> ${customerAddress}</p>
                    </div>
                    <div>
                        <p><strong>Invoice No:</strong> RINV${invoiceId.padStart(5, '0')}</p>
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
                const itemName = row.querySelector('td:nth-child(5)')?.textContent.trim() || '';
                const description = row.querySelector('td:nth-child(6)')?.textContent.trim() || '';
                const unit = row.querySelector('td:nth-child(10)')?.textContent.trim() || '';
                const price = parseFloat(row.querySelector('td:nth-child(7)')?.textContent.trim() || 0).toFixed(2);
                const qty = parseFloat(row.querySelector('td:nth-child(8)')?.textContent.trim() || 0).toFixed(2);
                const amount = parseFloat(row.querySelector('td:nth-child(9)')?.textContent.trim() || 0).toFixed(2);

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