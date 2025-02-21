<div class="modal-content">


        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p>Oferta# <b><?= $proposal['number'] ?></b></p>


            <div class="table-responsive">
            <table class="table table-bordered controls table-condensed" id="customDataTable">
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
                    <?php foreach($proposal_items as $item) { ?>
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
                            <?= $currency['prefix'] ?><span id="text_totals_value"><?= $proposal['value']; ?></span><?= $currency['suffix'] ?>
                        </th>
                        <th>
                            <?= $currency['prefix'] ?><span id="text_totals_tax"><?= $proposal['tax']; ?></span><?= $currency['suffix'] ?>
                        </th>
                        <th>
                            <?= $currency['prefix'] ?><span id="text_totals_total"><?= $proposal['total']; ?></span><?= $currency['suffix'] ?>
                        </th>
                    </tr>
                </tfoot>

            </table>
            </div>

            <h6><?= __("Proposal Text") ?></h6>
            <p><?= $proposal['offer_text']; ?></p>

            <br>

            <h6><?= __("Notes") ?></h6>
            <p><?= $proposal['notes']; ?></p>

        </div>
        <div class="modal-footer">
            <div class="dropdown-primary dropdown open">
                <button class="btn btn-primary dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="far fa-fw fa-file-pdf"></i> <?= __('PDF') ?></button>
                <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <a href="<?= base_url('billing/pdf_proposal/view/'.$proposal['id']) ?>" class="dropdown-item waves-light waves-effect" target="_blank"><i class="far fa-fw fa-file-pdf"></i> <?= __('View') ?></a>
                    <a href="<?= base_url('billing/pdf_proposal/download/'.$proposal['id']) ?>" class="dropdown-item waves-light waves-effect"><i class="far fa-fw fa-file-pdf"></i> <?= __('Download') ?></a>

                </div>
            </div>




            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>

        </div>



</div>
