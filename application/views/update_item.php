<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manage Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 80%;
            margin: auto;
            background-color: #AC9F9FFF;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input {
            width: 90%;
            height: 40px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        textarea {
            width: 90%;
            height: 80px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        button {
            width: 95%;
            height: 40px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <a href="<?php echo base_url('dashboard'); ?>">Dashboard</a>
            <a href="<?php echo base_url('invoice'); ?>">Invoices</a>
            <a href="<?php echo base_url('customer'); ?>">Customer</a>
            <a href="<?php echo base_url('unit'); ?>">Unit</a>
            <a href="<?php echo base_url('return'); ?>">Return</a>
            <a href="<?php echo base_url('chart'); ?>">Chart</a>
            <a href="<?php echo base_url('invoiceReport'); ?>">Invoice Report</a>
            <a href="<?php echo base_url('returnReport'); ?>">Return Report</a>
            <a style="color:red:" href="<?php echo base_url('login'); ?>">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h1>Manage Items</h1>
        <form method="POST" action="<?php echo base_url('dashboard/item'); ?>">
            <label>Item Name:</label>
            <input type="text" name="item_name" class="input" placeholder="Enter item name" required>
            <label>Item Price:</label>
            <input type="text" name="item_price" class="input" placeholder="Enter item price" required>
            <label>Item Description:</label>
            <textarea name="item_description" placeholder="Enter item description" required></textarea>
            <button type="submit">Add Item</button>
        </form>
        <form method="POST" action="<?php echo base_url('dashboard/update_item'); ?>">
            <label>Item ID:</label>
            <input type="text" name="item_id" class="input" placeholder="Enter item ID to update" required>
            <label>Item Name:</label>
            <input type="text" name="item_name" class="input" placeholder="Enter new item name" required>
            <label>Item Price:</label>
            <input type="text" name="item_price" class="input" placeholder="Enter new item price" required>
            <label>Item Description:</label>
            <textarea name="item_description" placeholder="Enter new item description" required></textarea>
            <button type="submit">Update Item</button>
        </form>
        <form method="POST" action="<?php echo base_url('dashboard/delete_item'); ?>">
            <label>Item ID:</label>
            <input type="text" name="item_id" class="input" placeholder="Enter item ID to delete" required>
            <button type="submit">Delete Item</button>
        </form>
    </div>
</body>
</html>