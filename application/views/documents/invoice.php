
                <div class="row">
                    <div class="col-xs-4">
                        <h1 class="text-uppercase"><?= __p("INVOICE",$l_id); ?></h1>
                    </div>
                    <div class="col-xs-4 text-center">

                        <?= __p("Number",$l_id); ?> <b><?= $data['invoice']['number']; ?></b><br>
                        <?= __p("Date",$l_id); ?> <b><?= date_display($data['invoice']['date']); ?></b><br>
                        <?php if($data['invoice']['due_date'] != "") { ?>
                            <?= __p("Due Date",$l_id); ?> <b><?= date_display($data['invoice']['due_date']); ?></b><br>
                        <?php } ?>
                        <?= __p("Currency",$l_id); ?> <b><?= $data['currency']['code']; ?></b><br>

                    </div>
                    <div class="col-xs-4 text-right">
                        <img src="<?= base_url()?>public/logo_pdf.jpg" class="max-height-50">
                    </div>

                    <hr>
                </div>

                <div class="row">

                    <?php if($data['invoice']['status'] == "Canceled") { ?>
                        <div class="col-xs-12 text-center">
                            <h1 class="text-red text-danger text-uppercase"><?= __p("CANCELED",$l_id); ?></h1>
                        </div>
                    <?php } ?>


                    <div class="col-xs-6">
                        <h4 class="text-uppercase"><?= __p("Supplier",$l_id); ?></h4>
                        <b><?= $data['entity']['name']; ?></b>
                        <p>
                            <?= $data['entity']['description']; ?>
                        </p>

                    </div>

                    <div class="col-xs-6 text-right">
                        <h4 class="text-uppercase"><?= __p("Client",$l_id); ?></h4>
                        <b><?= $persistent_client_info['name']; ?></b>
                        <p>
                            <?= __p("Tax ID",$l_id); ?>: <?= $persistent_client_info['company_taxid']; ?><br>
                            <?= __p("Company ID",$l_id); ?>: <?= $persistent_client_info['company_id']; ?><br>
                            <?= __p("Address",$l_id); ?>: <?= $persistent_client_info['address']; ?><br>
                            <?= $persistent_client_info['city']; ?>, <?= $persistent_client_info['state']; ?>, <?= $persistent_client_info['country']; ?><br>
                        </p>
                    </div>

                </div>


                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center th-width-6"><?= __p("Cur. No.",$l_id); ?></th>

                                    <th class="text-centerX"><?= __p("Product/service name",$l_id); ?></th>

                                    <th class="text-center"><?= __p("Quantity",$l_id); ?></th>
                                    <th class="text-center"><?= __p("Unit Price",$l_id); ?></th>
                                    <th class="text-center"><?= __p("Tax Rate",$l_id); ?></th>
                                    <th class="text-center"><?= __p("Value",$l_id); ?></th>
                                    <th class="text-center"><?= __p("Tax Value",$l_id); ?></th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php $i=1; foreach($data['invoice_items'] as $item) { $f_item = $this->db->get_where('app_items', array('id' => $item['item_id']))->row_array(); ?>
                                    <tr>
                                        <td class="text-center"><?= $i; ?></td>


                                        <td>

                                            <?= $item['name']; ?>

                                            <?php if(!empty($item['description'])) { ?>
                                                <br><span class="text-muted"><?= $item['description']; ?></span>
                                            <?php } ?>
                                        </td>


                                        <td class="text-center"><?= $item['qty']; ?></td>
                                        <td class="text-center"><?= $item['price']; ?></td>

                                        <?php if($item['taxrate'] > 0) { ?>
                                            <td class="text-center"><?= $item['taxrate']; ?>%</td>
                                        <?php } else { ?>
                                            <td class="text-center"><span class="text-muted"><?= __p("non-VAT Payer",$l_id); ?></span></td>
                                        <?php } ?>
                                        <td class="text-center"><?= $item['value']; ?></td>

                                        <?php if($item['taxrate'] > 0) { ?>
                                            <td class="text-center"><?= $item['tax']; ?></td>
                                        <?php } else { ?>
                                            <td class="text-center"><span class="text-muted"><?= __p("non-VAT Payer",$l_id); ?></span></td>
                                        <?php } ?>

                                    </tr>
                                <?php $i++; } ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="5"><?= __p("Subtotal",$l_id); ?></th>

                                    <th class="text-center"><?= $data['invoice']['value']; ?></th>
                                    <th class="text-center"><?= $data['invoice']['tax']; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="5"><?= __p("TOTAL",$l_id); ?></th>

                                    <th colspan="2" class="text-center"><?= $data['invoice']['total']; ?> <?= $data['currency']['code']; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <?php if($data['invoice']['rate'] > 1) { ?>
                        <div class="col-xs-12 text-left">
                            <p><b><?= __p("Exchange Rate",$l_id); ?>: 1 <?= $data['currency']['code']; ?> = </b><?= $data['invoice']['rate'] ?> lei</p>
                        </div>
                    <?php } ?>


                    <?= nl2br($data['invoice']['public_notes']); ?>
                    <br><br>
                    <?= nl2br(get_setting('invoice_text')); ?>

                    <hr>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <b><?= __p("Issued by",$l_id); ?></b><br>

                        <?php if($data['invoice']['issued_by'] != 0) { ?>

                            <?= $data['issued_by']['name']; ?><br>


                        <?php } else { ?>

                            <?= $this->session->staff_name; ?><br>
                            <?= $this->session->staff_ci; ?>


                        <?php } ?>





                    </div>


                </div>
