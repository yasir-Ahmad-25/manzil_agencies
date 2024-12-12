<!DOCTYPE html>
<?php
$locale = $locale ?? 'en';
?>
<?php
$dir = 'ltr';
if ($locale == 'ar') {
    $dir = 'rtl';
    ?>
    <style>
        #projeect {
            font-size: 23px;
            float: left;
        }

        table th {
            font-size: 24px;
        }

        table tr td {
            font-size: 20px;
        }

        #total_amount {
            font-size: 23px;
        }
    </style>
<?php } ?>
<html dir="<?= $dir ?>" lang="<?= $locale ?>">

<?php
$session = session();
$titleName = 'INV_';
?>


<head>
    <meta charset="utf-8">
    <title><?= 'INV_' ?></title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        /* body {

            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        } */

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 120px;
        }

        #logo img {
            width: 190px;
        }

        h2 {

            color: #5D6975;
            font-size: 2em;
            line-height: 1.4em;
            font-weight: bold;
            margin: 0px;
            margin-left: 0px;
        }

        #divh2 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            text-align: center;
            padding: 0px;
            margin: 0px;
            margin-bottom: 15px;
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {}

        table th {
            background: #F5F5F5;

        }

        table th,
        table td {
            text-align: center;
            padding: 5px 20px;

        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: bold;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: center;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 3px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }






        @media print {
            @page {
                margin-top: 0;
            }
        }

        @media print {
            .hide-on-print {
                display: none;
            }

            .print-button {
                display: none;
            }
        }

        .print-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            margin-left: 600px;
        }

        /* Container styles to center the button */
        .print-container {
            display: flex;
            justify-content: center;
            /* Centers the button horizontally */
            margin-top: 20px;
            /* Adds some space above the button */
        }

        .print-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            /* Removed the margin-top here, added it to the container instead */
        }

        .print-button:hover {
            background-color: #45a049;
        }

        @page {
            background-image: url('<?php echo base_url(); ?>public/assets/images/barkaale.jpg');
            background-repeat: no-repeat;
            background-image-resize: 6;
            background-size: cover;
        }
    </style>
</head>

<body style="background-image:url('<?php echo base_url(); ?>public/assets/images/barkaale.jpg');
            background-repeat: no-repeat;background-size:cover;">
    <!-- <img src="<?//php echo base_url(); ?>public/assets/admin/images/core/invoice.jpg" alt=""> -->
    <div class="container-fluid" style="">
        <header class="clearfix" style="margin-top:40px;">
            <div id="logo">
                <!-- <img src="<?//php echo base_url() ?>img/BIZMART/BizMartUpdate-01.png"> -->
            </div>

            <p style=" text-align:right; margin-top:-20px; margin-right:10px; font-size:large">
                <b><?= lang('Site.Voucher.date') ?>:<?php echo date('m-d-Y') ?></b>
            </p>
            <div style=" !important;" id="divh2">
                <h2 style="">Invoice</h2>
            </div>
            <table style="width:100%">
                <tr>

                    <td style="text-align:left;">

                        <div>
                            <h4 style="border-bottom:1px solid black; margin-bottom:6px;">Tenant Details</h4>
                            <div><span><b><?= "Name" ?>:
                                    </b><?php echo $data->cust_name ?></span>
                            </div>
                        </div>
                        <div><span><b><?= lang('Phone') ?>: </b><?php echo $data->cust_tell ?> </span></div>
                        <div><span><b><?= lang('Email') ?>: </b><?php echo $data->cust_email ?> </span></div>
    </div>
    </div>
    </td>
    <td style="text-align:right">

        <div id="company" class="clearfix" style="">
            <div><b><?= "Barakaale Apartments" ?></b></div>
            <div><b><?= "Taleeh-Hodan Mogadishu" ?><br /></b></div>
            <div><b><?= "+252 617643434" ?></b></div>
            <div><b><?= "+252 622643434" ?></b></div>
            <div><a href="<?= "info@barakaale.so" ?>"><b><?= "info@barakaale.so" ?></b></a></div>
        </div>
    </td>
    </tr>
    </table>
    </header>
    <main>

        <h4><?= $bill_month ?></h4>
        <?php $total_bill = 0 ?>
        <table style="direction:<?= $dir ?>; margin-top:25px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th><b><?= "Bill Date" ?></b></th>
                    <th><b><?= "Source" ?></b></th>
                    <?php if ($bill_type == 0): ?>

                    <?php else: ?>
                        <th><b><?= "Previous" ?></b></th>
                        <th><b><?= "Current" ?></b></th>
                        <th><b><?= "Usage" ?></b></th>
                        <th><b><?= "Rate" ?></b></th>
                    <?php endif; ?>
                    <th><b><?= "Amount" ?></b></th>
                    <!-- <th><b><?//= lang('Site.customer.paid') ?></b></th>
                        <th><b><?//= lang('Site.labels.total_due') ?></b></th> -->
                    <!-- <th><b><?//= lang('Site.labels.payment_type') ?></b></th>
                        <th><b><?//= lang('Site.labels.murabaha_duration') ?></b></th> -->

                </tr>
            </thead>
            <tbody>
                <?php $counter = 1;
                foreach ($bills as $index => $bill): ?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= date('d-m-Y', strtotime($bill['bill_date'])) ?></td>
                        <td><?= $bill['source'] ?></td>
                        <?php if ($bill_type == 0): ?>
                        <?php else: ?>
                            <td><?= ($bill['previous_reading'] ==0)? '' : $bill['previous_reading'] ?></td>
                            <td><?= ($bill['current_reading'] ==0)?'': $bill['current_reading'] ?></td>
                            <td><?= $bill['usage']==0?'':$bill['usage'] ?></td>
                            <td><?= ($bill['reading_rate']==0)?'':$bill['reading_rate'] ?></td>
                        <?php endif; ?>
                        <td>$<?= $bill['amount'] ?></td>
                    </tr>
                    <?php $total_bill += $bill['amount']; ?>
                    <?php $counter++ ?>
                <?php endforeach; ?>
                <tr>
                    <td id="total_amount" colspan="7" style="text-align:right;font-weight:bold;">
                        <?php echo "TOTAL" . ": $" . $total_bill ?>
                    </td>
                </tr>
                <tr>
                    <td id="total_amount" colspan="7" style="text-align:right;font-weight:bold;">
                        <?php echo "PAID AMOUNT" . ": $" . $paid_amount ?>
                    </td>
                </tr>
            </tbody>
        </table>


    </main>
    <!-- <hr> -->


    <!-- </div> -->
</body>
<script>
    // This function will be called when the window's load event fires
    window.onload = function () {
        window.print(); // Triggers the print dialog
        window.onafterprint = function () {
            window.history.back(); // Go back to the previous page after printing
        }
    };
</script>

</html>