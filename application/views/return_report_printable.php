<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-subtitle {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .report-meta {
            font-size: 12px;
            margin-bottom: 5px;
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
        .summary {
            margin-top: 20px;
            text-align: right;
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
    <div class="report-header">
        <div class="report-title">Return Report</div>
        <div class="report-subtitle">Your Company Name</div>
        <div class="report-meta">
            <?php if (!empty($start_date) && !empty($end_date)): ?>
                Period: <?php echo date('Y-m-d', strtotime($start_date)); ?> to <?php echo date('Y-m-d', strtotime($end_date)); ?>
            <?php else: ?>
                All-Time Report
            <?php endif; ?>
        </div>
        <div class="report-meta">Generated on: <?php echo date('Y-m-d H:i:s'); ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Return #</th>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Customer</th>
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
            $current_return_id = null;
            $return_subtotal = 0;
            
            foreach ($returns as $return): 
                // Reset subtotal when we encounter a new return
                if ($current_return_id != $return->return_id) {
                    if ($current_return_id !== null) {
                        // Print subtotal row for previous return
                        echo "<tr style='background-color: #f2f2f2; font-weight: bold;'>";
                        echo "<td colspan='9' style='text-align: right;'>Return Subtotal:</td>";
                        echo "<td>" . number_format($return_subtotal, 2) . "</td>";
                        echo "</tr>";
                    }
                    $current_return_id = $return->return_id;
                    $return_subtotal = 0;
                }
                
                $return_subtotal += $return->total;
            ?>
                <tr>
                    <td><?php echo $return->return_id; ?></td>
                    <td><?php echo $return->invoice_id; ?></td>
                    <td><?php echo date('Y-m-d', strtotime($return->created_at)); ?></td>
                    <td><?php echo $return->customer_name; ?></td>
                    <td><?php echo $return->item_name; ?></td>
                    <td><?php echo $return->item_description; ?></td>
                    <td style="text-align: right;"><?php echo $return->quantity; ?></td>
                    <td><?php echo $return->unit_name; ?></td>
                    <td style="text-align: right;"><?php echo number_format($return->item_price, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($return->total, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (!empty($returns)): ?>
                <!-- Print subtotal for the last return -->
                <tr style='background-color: #f2f2f2; font-weight: bold;'>
                    <td colspan='9' style='text-align: right;'>Return Subtotal:</td>
                    <td><?php echo number_format($return_subtotal, 2); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <p>Grand Total: <?php echo number_format($grand_total, 2); ?></p>
    </div>

    <div class="footer">
        <p>This is a computer-generated report and requires no signature.</p>
    </div>

    <!-- Print button - only visible on screen, not when printing -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Report
        </button>
        <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>