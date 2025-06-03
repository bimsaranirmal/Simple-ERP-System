<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
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
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        /* Print media styles */
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
        <div class="report-title">Invoice Report</div>
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
                <th>Invoice #</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $current_invoice_id = null;
            $invoice_subtotal = 0;
            
            if (!empty($invoices)):
                foreach ($invoices as $invoice): 
                    // Reset subtotal when we encounter a new invoice
                    if ($current_invoice_id != $invoice->invoice_id) {
                        if ($current_invoice_id !== null) {
                            // Print subtotal row for previous invoice
                            echo "<tr style='background-color: #f2f2f2; font-weight: bold;'>";
                            echo "<td colspan='7' style='text-align: right;'>Invoice Subtotal:</td>";
                            echo "<td>" . number_format($invoice_subtotal, 2) . "</td>";
                            echo "</tr>";
                        }
                        $current_invoice_id = $invoice->invoice_id;
                        $invoice_subtotal = 0;
                    }
                    
                    $invoice_subtotal += $invoice->total;
            ?>
                <tr>
                    <td><?php echo $invoice->invoice_id; ?></td>
                    <td><?php echo date('Y-m-d', strtotime($invoice->created_at)); ?></td>
                    <td><?php echo $invoice->customer_name; ?></td>
                    <td><?php echo $invoice->item_name; ?></td>
                    <td style="text-align: right;"><?php echo $invoice->quantity; ?></td>
                    <td><?php echo $invoice->unit_name; ?></td>
                    <td style="text-align: right;"><?php echo number_format($invoice->item_price, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($invoice->total, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (!empty($invoices)): ?>
                <!-- Print subtotal for the last invoice -->
                <tr style='background-color: #f2f2f2; font-weight: bold;'>
                    <td colspan='7' style='text-align: right;'>Invoice Subtotal:</td>
                    <td><?php echo number_format($invoice_subtotal, 2); ?></td>
                </tr>
            <?php endif; ?>
            
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No invoices found for selected criteria.</td>
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

    <!-- No-print section with Print, Close and Share buttons -->
    <div class="no-print">
        <button onclick="window.print();" 
                style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Report
        </button>
        <button onclick="window.close();" 
                style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
        
        <!-- WhatsApp Share Button - only show if PDF URL is available -->
        <?php if (isset($pdf_url) && !empty($pdf_url)): ?>
        <?php $report_filename = isset($pdf_filename) ? $pdf_filename : 'invoice_report.pdf'; ?>
        <div style="margin-top: 10px;">
            <button onclick="shareReportOnWhatsApp('<?php echo $pdf_url; ?>', '<?php echo $report_filename; ?>')"
                    style="padding: 10px 20px; background-color: #25D366; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Share on WhatsApp
            </button>
        </div>
        <?php else: ?>
        <!-- Fallback if PDF URL is somehow not generated, though controller should always provide it -->
        <div style="margin-top: 10px;">
            <button onclick="shareCurrentPageOnWhatsApp()"
                    style="padding: 10px 20px; background-color: #25D366; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Share on WhatsApp
            </button>
        </div>
        <?php endif; ?>
    </div>
 
    <script>
        async function shareReportOnWhatsApp(documentUrl, fileName) {
            if (!documentUrl) {
                alert('PDF Report URL is not available.');
                return;
            }

            const shareTitle = "Invoice Report";
            const shareTextLink = "Here is your invoice report: " + documentUrl;
            const shareTextFile = "Please find the attached invoice report PDF.";

            if (navigator.share) {
                try {
                    const response = await fetch(documentUrl);
                    if (!response.ok) {
                        console.error('Failed to fetch PDF report for sharing:', response.statusText);
                        const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(shareTextLink);
                        window.open(whatsappUrl, '_blank');
                        return;
                    }
                    const blob = await response.blob();
                    const file = new File([blob], fileName, { type: 'application/pdf' });

                    if (navigator.canShare && navigator.canShare({ files: [file] })) {
                        await navigator.share({ title: shareTitle, text: shareTextFile, files: [file] });
                        console.log('Report file shared successfully via Web Share API.');
                    } else {
                        console.log('File sharing not supported, trying URL via Web Share API for report.');
                        await navigator.share({ title: shareTitle, text: shareTextLink, url: documentUrl });
                        console.log('Report URL shared successfully via Web Share API.');
                    }
                } catch (error) {
                    console.error('Error using Web Share API for report:', error);
                    const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(shareTextLink);
                    window.open(whatsappUrl, '_blank');
                }
            } else {
                console.log('Web Share API not supported, falling back to wa.me link for report.');
                const whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(shareTextLink);
                window.open(whatsappUrl, '_blank');
            }
        }
        
        function shareCurrentPageOnWhatsApp() {
            var message = "Here is your invoice report: " + window.location.href;
            var whatsappUrl = "https://wa.me/?text=" + encodeURIComponent(message);
            window.open(whatsappUrl, '_blank');
        }
    </script>
</body>
</html>