<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #<?php echo $invoice->id; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .totals { text-align: right; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE #<?php echo $invoice->id; ?></h1>
        <p>Date: <?php echo date('Y-m-d', strtotime($invoice->created_at)); ?></p>
    </div>

    <div>
        <strong>Bill To:</strong><br>
        <?php echo $invoice->customer_name; ?><br>
        <?php echo nl2br($invoice->customer_address); ?>
    </div>

    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $grand_total = 0;
            foreach ($invoice_items as $item): 
                $grand_total += $item->total;
            ?>
            <tr>
                <td><?php echo $item->item_name; ?></td>
                <td><?php echo $item->quantity; ?></td>
                <td>$<?php echo number_format($item->item_price, 2); ?></td>
                <td>$<?php echo number_format($item->total, 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <strong>Total: $<?php echo number_format($grand_total, 2); ?></strong>
    </div>
</body>
</html>