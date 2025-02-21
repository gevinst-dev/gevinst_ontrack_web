<div class="modal-content">


        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <p><?= __("Name") ?> <b><?= $recurring['name'] ?></b></p>
            <p><?= __("Client") ?> <b><?= get_client_name($recurring['client_id']) ?></b></p>
            <p><?= __("Currency") ?> <b><?= $currency['code'] ?></b></p>
            <p><?= __("Type") ?> <b><?= $recurring['type'] ?></b></p>

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
                    <?php foreach($recurring_items as $item) {
                        $currency = $this->setting->get_currency($item['currency_id']);

                        ?>
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


            </table>
            </div>





            <h6><?= __("Notes") ?></h6>
            <p><?= $recurring['notes']; ?></p>

        </div>
        <div class="modal-footer">


            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>

        </div>



</div>
