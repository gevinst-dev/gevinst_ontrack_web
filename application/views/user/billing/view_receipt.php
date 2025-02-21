<div class="modal-content">
    

        <div class="modal-header">
            <h4 class="modal-title"><?= $title ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <table class="table table-bordered">

                <tbody>
                    <tr>
                        <th><?= __("Method") ?></th>
                        <td><?= payment_method_name($receipt['paymentmethod_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Date") ?></th>
                        <td><?= date_display($receipt['date']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Amount") ?></th>
                        <td><?= $receipt['amount']; ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Currency") ?></th>
                        <td><?= get_currency_name($receipt['currency_id']); ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Tagged Invoices") ?></th>
                        <td>

                            <?php
                                if($receipt['tagged_invoices'] != "") {
                                    $tagged_invoices = unserialize($receipt['tagged_invoices']);
                                    foreach ($tagged_invoices as $tagged_invoice) {
                                        $invoice = $this->db->get_where('app_invoices', array('id' => $tagged_invoice))->row_array();
                                        ?>
                                            <?= $invoice['number']; ?>&nbsp;
                                        <?php
                                    }

                                }

                            ?>

                        </td>
                    </tr>

                    <tr>
                        <th><?= __("Reference") ?></th>
                        <td><?= $receipt['reference']; ?></td>
                    </tr>

                    <tr>
                        <th><?= __("Description") ?></th>
                        <td><?= $receipt['description']; ?></td>
                    </tr>



                </tbody>

            </table>




        </div>
        <div class="modal-footer">
            
            <a href="<?= base_url('billing/receipt_pdf/view/'.$receipt['id']); ?>" class="btn btn-primary waves-effect" target="_blank"><i class="fas fa-fw fa-print"></i> <?= __('Print') ?></a>
            <a href="<?= base_url('billing/receipt_pdf/download/'.$receipt['id']); ?>" class="btn btn-primary waves-effect" target="_blank"><i class="fas fa-fw fa-download"></i> <?= __('Download') ?></a>
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?= __("Close") ?></button>
        </div>


</div>
