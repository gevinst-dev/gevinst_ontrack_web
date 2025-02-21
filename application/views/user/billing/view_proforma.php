<div class="modal-content">


        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><strong><?= $proforma['number'] ?></strong></p>


            <div class="table-responsive">
            <table class="table table-bordered controls" id="customDataTable">
                <thead>
                    <tr>
                        <th><?= __("Item") ?></th>
                        <th><?= __("Description") ?></th>

                        <th><?= __("Quantity") ?></th>
                        <th><?= __("Price") ?></th>
                        <th><?= __("Tax Rate") ?></th>

                        <th><?= __("Value") ?></th>
                        <th><?= __("Tax") ?></th>
                        <th><?= __("Total") ?></th>
                    </tr>
                </thead>
                <tbody class="entries">
                    <?php foreach($proforma_items as $item) { ?>
                        <tr class="entry">
                            <td>
                                <span id="text_item_name"><?= $item['name']; ?></span><br>
                                <span id="text_item_type" class="text-muted"><?= __($item['type']); ?></span>
                            </td>

                            <td>
                                <?= $item['description']; ?>
                            </td>


                            <td>
                                <?= $item['qty']; ?>
                            </td>

                            <td>
                                <?= $item['price']; ?>
                            </td>

                            <td>
                                <?= $item['taxrate']; ?>
                            </td>

                            <td>
                                <?= $currency['prefix'] ?><span id="text_value"><?= $item['value']; ?></span><?= $currency['suffix'] ?>
                            </td>

                            <td>
                                <?= $currency['prefix'] ?><span id="text_vat"><?= $item['tax']; ?></span><?= $currency['suffix'] ?>
                            </td>

                            <td>
                                <?= $currency['prefix'] ?><span id="text_total"><?= $item['total']; ?></span><?= $currency['suffix'] ?>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"><?= __("TOTALS") ?></th>

                        <th>
                            <?= $currency['prefix'] ?><span id="text_totals_value"><?= $proforma['value']; ?></span><?= $currency['suffix'] ?>
                        </th>
                        <th>
                            <?= $currency['prefix'] ?><span id="text_totals_tax"><?= $proforma['tax']; ?></span><?= $currency['suffix'] ?>
                        </th>
                        <th>
                            <?= $currency['prefix'] ?><span id="text_totals_total"><?= $proforma['total']; ?></span><?= $currency['suffix'] ?>
                        </th>
                    </tr>
                </tfoot>

            </table>
            </div>

        </div>
        <div class="modal-footer">
            <a href="<?= base_url('billing/proforma_pdf/view/'.$proforma['id']); ?>" class="btn btn-primary waves-effect" target="_blank"><i class="fas fa-fw fa-print"></i> <?= __('Print') ?></a>
            <a href="<?= base_url('billing/proforma_pdf/download/'.$proforma['id']); ?>" class="btn btn-primary waves-effect" target="_blank"><i class="fas fa-fw fa-download"></i> <?= __('Download') ?></a>

            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>

        </div>



</div>
