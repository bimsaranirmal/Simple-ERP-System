<!-- filepath: c:\my\htdocs\codeerp\application\views\customer.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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
        
        input, textarea {
            width: 97%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: inherit;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        
        table th, table td {
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
        
        table td button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            width: auto;
        }
        
        table td button:hover {
            background-color: #45a049;
        }
        
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .delete-btn {
            background-color: #FF0000;
        }
        
        .update-btn {
            background-color: #00AA1E;
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
        <h1>Customer Management</h1>
        
        <div class="view-buttons">
            <button id="formButton" class="view-button active">Add Customer</button>
            <button id="tableButton" class="view-button">View Customers</button>
        </div>
        
        <div class="content-wrapper">
            <!-- Add Customer Form -->
            <div id="formContainer" class="form show">
                <form method="POST" action="<?php echo base_url('customer/save'); ?>">
                    <div class="form-group">
                        <label>Customer Name:</label>
                        <input type="text" name="customer_name" placeholder="Enter customer name" required>
                    </div>
                    <div class="form-group">
                        <label>Customer Code:</label>
                        <input type="text" name="customer_code" placeholder="Enter customer code" required>
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <textarea name="address" placeholder="Enter address"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Mobile:</label>
                        <input type="text" name="mobile" placeholder="Enter mobile number">
                    </div>
                    <button type="submit">Save Customer</button>
                </form>
            </div>

            <!-- Customers Table -->
            <div id="tableContainer" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?php echo $customer->id; ?></td>
                                    <td><?php echo $customer->customer_name; ?></td>
                                    <td><?php echo $customer->customer_code; ?></td>
                                    <td><?php echo $customer->address; ?></td>
                                    <td><?php echo $customer->mobile; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" onclick="deleteCustomer('<?php echo $customer->id; ?>')" class="delete-btn">Delete</button>
                                            <button type="button" onclick="editCustomer('<?php echo $customer->id; ?>')" class="update-btn">Update</button>
                                        </div>                    
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="no-data">No customers found.</td>
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
        
        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                window.location.href = '<?php echo base_url("customer/delete/"); ?>' + customerId;
            }
        }
        
        function editCustomer(customerId) {
            window.location.href = '<?php echo base_url("customer/edit/"); ?>' + customerId;
        }
    </script>
</body>
</html>