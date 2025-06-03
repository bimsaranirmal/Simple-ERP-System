<!-- filepath: c:\my\htdocs\codeerp\application\views\edit_invoice.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
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
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .form {
            max-width: 80%;
            margin: auto;
            padding: 30px;
            background-color: #C9C5C5FF;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        }

        function updateCustomerDetails(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const address = selectedOption.getAttribute('data-address') || '';
            document.getElementById('customer-address').value = address; // Update the address field
        }

        function updateTotal(quantityInput) {
            const row = quantityInput.closest('.item-row');
            const priceInput = row.querySelector('.item-price');
            const totalInput = row.querySelector('.total');

            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            totalInput.value = (price * quantity).toFixed(2); // Calculate and update total
        }

        function addItemRow() {
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
                            <input type="number" name="quantity[]" class="quantity" min="0.5" value="1"
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
                <button type="button" class="remove-item" onclick="removeItem(this)" style="background-color: #FF0000; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Remove</button>
            </div>
            `;
            container.appendChild(newRow);
        }

        function removeItem(button) {
            const row = button.closest('.item-row');
            row.remove();
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
        <form method="POST" action="<?php echo base_url('return/update'); ?>">
            <div class="form">
                <h1>Edit Invoice</h1>

                <input type="hidden" name="return_id" value="<?php echo $return->return_id; ?>">
                <input type="hidden" name="invoice_id" value="<?php echo $return->invoice_id; ?>">

                <!-- filepath: c:\my\htdocs\codeerp\application\views\edit_invoice.php -->
                <div class="form-group">
                    <label for="customer-select">Select Customer:</label>
                    <select id="customer-select" name="customer_id" onchange="updateCustomerDetails(this)" required>
                        <option value="">-- Select a Customer --</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer->id; ?>" data-address="<?php echo $customer->address; ?>"
                                <?php echo $customer->id == $return->customer_id ? 'selected' : ''; ?>>
                                <?php echo $customer->customer_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer-address">Customer Address:</label>
                    <textarea id="customer-address" name="customer_address"
                        readonly><?php echo $return->customer_address; ?></textarea>
                </div>

                <div id="items-container">
                    <?php foreach ($return_items as $item): ?>
                        <div class="form-group item-row" style="display: flex; align-items: center; gap: 20px;">
                            <div style="flex: 1;">
                                <label for="item-select">Select Item:</label>
                                <select name="item_id[]" class="item-select" onchange="updateItemDetails(this)" required>
                                    <option value="">-- Select an Item --</option>
                                    <?php foreach ($items as $dropdown_item): ?>
                                        <option value="<?php echo $dropdown_item->id; ?>" <?php echo $dropdown_item->id == $item->item_id ? 'selected' : ''; ?>>
                                            <?php echo $dropdown_item->item_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div style="flex: 2;">
                                <label for="item-description">Item Description:</label>
                                <input type="text" name="item_description[]" class="item-description readonly"
                                    value="<?php echo $item->item_description; ?>" readonly>
                            </div>



                            <div style="flex: 1;">
                                <label for="item-price">Item Price:</label>
                                <input type="text" name="item_price[]" class="item-price readonly" style="text-align: right;"
                                    value="<?php echo $item->item_price; ?>" readonly >
                            </div>

                            <div style="flex: 1;">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity[]" class="quantity" style="text-align: right;"
                                    value="<?php echo $item->quantity; ?>" required>
                            </div>

                            <div style="flex: 1;">
                                <label for="total">Total:</label>
                                <input type="text" name="total[]" class="total readonly" style="text-align: right;" value="<?php echo $item->total; ?>"
                                    readonly>
                            </div>

                            <div style="flex: 1;">
                                <label for="unit-select">Select Unit:</label>
                                <select name="unit_id[]" class="unit-select" required>
                                    <option value="">-- Select a Unit --</option>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?php echo $unit->id; ?>" <?php echo $unit->id == $item->unit_id ? 'selected' : ''; ?>>
                                            <?php echo $unit->unit_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <button type="button" class="remove-item" onclick="removeItem(this)"
                                    style="background-color: #FF0000; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" onclick="addItemRow()"
                    style="margin-top: 10px; background-color: #007BFF; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Add
                    Item</button>

                <button type="submit" style="margin-top: 20px;">Update Invoice</button>
            </div>
        </form>
    </div>
</body>

</html>