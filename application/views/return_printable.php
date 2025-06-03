<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return #<?php echo $return_data->return_id; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .company-info {
            flex: 1;
        }
        .return-info {
            flex: 1;
            text-align: right;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .return-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .totals table {
            width: 300px;
            margin-left: auto;
            margin-right: 0;
        }
        .totals table td {
            border: none;
        }
        .totals table td:last-child {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            border-top: 1px solid #333;
            padding-top: 5px;
            text-align: center;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div class="company-info">
            <div class="company-name">Your Company Name</div>
            <div>123 Company Street</div>
            <div>Business City, State 12345</div>
            <div>Phone: (123) 456-7890</div>
            <div>Email: info@yourcompany.com</div>
        </div>
        <div class="return-info">
            <div class="return-title">RETURN NOTE</div>
            <div><strong>Return #:</strong> <?php echo $return_data->return_id; ?></div>
            <div><strong>Invoice #:</strong> <?php echo $return_data->invoice_id; ?></div>
            <div><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($return_data->created_at)); ?></div>
        </div>
    </div>

    <div class="customer-info">
        <div><strong>Customer:</strong> <?php echo $return_data->customer_name; ?></div>
        <div><strong>Address:</strong> <?php echo $return_data->customer_address; ?></div>
        <?php if(!empty($return_data->customer_phone)): ?>
        <div><strong>Phone:</strong> <?php echo $return_data->customer_phone; ?></div>
        <?php endif; ?>
        <?php if(!empty($return_data->customer_email)): ?>
        <div><strong>Email:</strong> <?php echo $return_data->customer_email; ?></div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($return_items as $i => $item): 
                $total += $item->total;
            ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $item->item_name; ?></td>
                    <td><?php echo $item->item_description; ?></td>
                    <td style="text-align: right;"><?php echo $item->quantity; ?></td>
                    <td><?php echo $item->unit_name; ?></td>
                    <td style="text-align: right;"><?php echo number_format($item->item_price, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($item->total, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td><?php echo number_format($total, 2); ?></td>
            </tr>
            <tr>
                <td>Total Amount:</td>
                <td><?php echo number_format($total, 2); ?></td>
            </tr>
        </table>
    </div>

    <div class="signature">
        <div class="signature-box">
            Customer Signature
        </div>
        <div class="signature-box">
            Authorized Signature
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated document and requires no signature if printed with a digital signature.</p>
        <p>Return Policy: Items must be unused and in original packaging. Returns accepted within 14 days of purchase.</p>
    </div>

    <!-- Print button - only visible on screen, not when printing -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Return
        </button>
        <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>