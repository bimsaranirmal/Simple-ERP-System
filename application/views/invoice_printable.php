<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $invoice->invoice_id; ?></title>
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
        .invoice-info {
            flex: 1;
            text-align: right;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-title {
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
        <div class="invoice-info">
            <div class="invoice-title">INVOICE</div>
            <div><strong>Invoice #:</strong> <?php echo $invoice->id; ?></div>
            <div><strong>Date:</strong> <?php echo date('Y-m-d', strtotime($invoice->created_at)); ?></div>
        </div>
    </div>

    <div class="customer-info">
        <div><strong>Bill To:</strong></div>
        <div><strong><?php echo $invoice->customer_name; ?></strong></div>
        <div><?php echo nl2br(htmlspecialchars($invoice->customer_address)); ?></div>
        <?php if(!empty($invoice->customer_phone)): ?>
        <div><strong>Phone:</strong> <?php echo $invoice->customer_phone; ?></div>
        <?php endif; ?>
        <?php if(!empty($invoice->customer_email)): ?>
        <div><strong>Email:</strong> <?php echo $invoice->customer_email; ?></div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item #</th>
                <th>Description</th>
                <th>Unit</th>
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
                    <td><?php echo $item->item_id; ?></td>
                    <td><?php echo $item->item_name; ?><br><small><?php echo $item->item_description; ?></small></td>
                    <td><?php echo $item->unit_name ?? ''; ?></td>
                    <td style="text-align: right;"><?php echo $item->quantity; ?></td>
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
                <td><?php echo number_format($grand_total, 2); ?></td>
            </tr>
            <tr>
                <td>Total Amount:</td>
                <td><?php echo number_format($grand_total, 2); ?></td>
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
        <p>Payment Terms: Payment due within 30 days. Please make checks payable to Your Company Name or pay via bank transfer.</p>
        <p>Thank you for your business!</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Invoice
        </button>
        <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="shareOnWhatsApp(
                            '<?php echo isset($pdf_url) ? $pdf_url : ''; ?>',
                            '<?php echo isset($pdf_filename) ? $pdf_filename : 'invoice.pdf'; ?>',
                            '<?php echo isset($direct_whatsapp_share_url) ? $direct_whatsapp_share_url : ''; ?>',
                            '<?php echo isset($customer_whatsapp_number) ? htmlspecialchars($customer_whatsapp_number) : ''; ?>'
                        )"
                style="padding: 10px 20px; background-color: #25D366; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Share on WhatsApp
        </button>
    </div>

    <script>
        async function shareOnWhatsApp(documentUrl, fileName, directWhatsappShareUrl, customerPhoneFallback) { 
            if (!documentUrl) {
                alert('PDF URL is not available for sharing.');
                return;
            }
            const shareTitle = "Invoice";
            const shareTextLink = "Here is your invoice: " + documentUrl;
            let shareTextFile = "Please find the attached invoice PDF.";

            if (customerPhoneFallback) {
                shareTextFile = `Invoice PDF for customer (${customerPhoneFallback}). Please select them in WhatsApp.`;
            }

            // 1. Attempt to share the PDF FILE using Web Share API.
            if (navigator.share) {
                console.log('Attempting to share PDF FILE via Web Share API.');
                try {
                    const response = await fetch(documentUrl);
                    if (!response.ok) {
                        console.error('Failed to fetch PDF for sharing:', response.statusText);
                        // If fetch fails, we'll fall through to other sharing methods.
                    } else {
                        const blob = await response.blob();
                        const file = new File([blob], fileName, { type: 'application/pdf' });
                        if (navigator.canShare && navigator.canShare({ files: [file] })) {
                            // Try to share the actual file using Web Share API
                            await navigator.share({
                                title: shareTitle,
                                text: shareTextFile, // Use file-specific text
                                files: [file],
                            });
                            console.log('File shared successfully via Web Share API.');
                            return; // SUCCESS: PDF File shared
                        } else {
                            console.log('File sharing not supported by navigator.canShare, trying to share URL (link) via Web Share API.');
                            await navigator.share({ title: shareTitle, text: shareTextLink, url: documentUrl });
                            console.log('URL shared successfully via Web Share API.');
                            return; 
                        }
                    }
                } catch (error) {
                    console.error('Error using Web Share API:', error);
                    // Fall through to other methods if Web Share API fails
                }
            } else {
                console.log('Web Share API not supported.');
            }

            if (directWhatsappShareUrl) {
                console.log('Web Share API not used or failed. Attempting to open customer chat directly with PDF link via:', directWhatsappShareUrl);
                window.open(directWhatsappShareUrl, '_blank');
                return; 
            }

            console.log('All other sharing methods failed or unavailable. Falling back to generic wa.me link with PDF link.');
            let finalFallbackUrl; let sanitizedPhoneForFinalFallback = ''; if (customerPhoneFallback && typeof customerPhoneFallback === 'string') { sanitizedPhoneForFinalFallback = customerPhoneFallback.trim().replace(/\D/g, '');
            }
            if (sanitizedPhoneForFinalFallback) {
                finalFallbackUrl = "https://wa.me/" + sanitizedPhoneForFinalFallback + "?text=" + encodeURIComponent(shareTextLink);
                console.log('Attempting to share LINK via wa.me link to fallback number:', finalFallbackUrl);
            } else {
                finalFallbackUrl = "https://wa.me/?text=" + encodeURIComponent(shareTextLink);
                console.log('Falling back to generic wa.me link (no phone number available for link).');
            }
            window.open(finalFallbackUrl, '_blank');
        }
    </script>
</body>
</html>