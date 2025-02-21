

<div class="row">

    <div class="col-xs-4">
        <img src="<?= base_url()?>public/logo_pdf.jpg">
        <br><br>
        <b><?= $data['entity']['name']; ?></b>
        <p>
            <?= $data['entity']['description']; ?>
        </p>
    </div>

    <div class="col-xs-8 text-center">
        <h4 class="text-bold"><?= __("RECEIPT"); ?></h4>
        <?= $data['receipt']['reference']; ?><br>
        <?= __("Date"); ?> <b><?= date_display($data['receipt']['date']); ?></b><br>


        <?php if($data['receipt']['status'] == "Canceled") { ?>
            <div class="text-center">
                <br>
                <h1 class="text-red text-danger text-uppercase"><?= __p("CANCELED",$l_id); ?></h1>
            </div>
        <?php } ?>


    </div>


<hr>
</div>

<div class="row">

    <div class="col-xs-12">
        <?= __("We have received from"); ?> <b><?= $data['client']['name']; ?>, <?= __("TAX ID"); ?> <?= $data['client']['company_taxid']; ?></b> -
        <?= $data['client']['address']; ?>, <?= $data['client']['city']; ?>, <?= $data['client']['state']; ?><br>

        <?= __("The following amount "); ?> <b><?= format_currency($data['receipt']['amount'], $data['receipt']['currency_id']); ?></b><br>

        <?= __("Representing "); ?> <b><?= $data['receipt']['description']; ?></b><br>
    </div>

    <hr>

</div>



<div class="row">
    <div class="col-xs-12 text-right">
        <b><?= __("Signature"); ?></b>
    </div>
</div>