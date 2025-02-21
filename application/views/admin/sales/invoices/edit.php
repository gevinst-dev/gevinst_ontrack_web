<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-4">
                <div class="page-header-title">
                    <i class="fas fa-sign-out-alt bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-right">
                    <a href="<?= base_url('admin/sales/invoices/pdf/view/'.$invoice['id']); ?>" class="btn btn-primary btn-md waves-effect waves-light" target="_blank"><i class="fas fa-fw fa-print"></i> <?= __('Print') ?></a>
                    <a href="<?= base_url('admin/sales/invoices/pdf/download/'.$invoice['id']); ?>" class="btn btn-primary btn-md waves-effect waves-light" target="_blank"><i class="fas fa-fw fa-download"></i> <?= __('Download') ?></a>

                    <button data-modal="admin/sales/invoices/send_email/<?= $invoice['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><i class="fas fa-fw fa-envelope"></i> <?= __('Email') ?></button>
                    <button data-modal="admin/sales/invoices/send_reminder/<?= $invoice['id']; ?>" class="btn btn-primary btn-md waves-effect waves-light"><i class="fas fa-fw fa-bell"></i> <?= __('Remind') ?></button>


                    <button  class="btn btn-default btn-md waves-effect waves-light go-back"><?= __('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-block">


                            <table class="hidden">
                                <tr class="templateEntry hidden">
                                    <td>

                                        <input type="hidden" name="items[item_id][]" id="item_id">
                                        <input type="hidden" name="items[type][]" id="item_type">

                                        <input type="text" class="form-control" name="items[name][]" id="item_name" placeholder="<?= __("Item name") ?>" required>

                                    </td>


                                    <td>
                                        <input type="text" class="form-control" name="items[description][]" id="item_description" placeholder="<?= __("Item description") ?>">
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control onchange-update-totals" name="items[qty][]" id="item_qty" required >
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control item_price onchange-update-totals" name="items[price][]" id="item_price" required>


                                    </td>

                                    <td>
                                        <input type="number" step="any" min="0" max="100" class="form-control item_taxrate onchange-update-totals" name="items[taxrate][]" id="item_taxrate" required >

                                    </td>

                                    <td>
                                        <?= $currency['prefix'] ?><span id="text_value"></span><?= $currency['suffix'] ?>
                                        <input type="hidden" name="items[value][]" id="item_value">
                                    </td>

                                    <td>
                                        <?= $currency['prefix'] ?><span id="text_vat"></span><?= $currency['suffix'] ?>
                                        <input type="hidden" name="items[tax][]" id="item_tax">
                                    </td>

                                    <td>
                                        <?= $currency['prefix'] ?><span id="text_total"></span><?= $currency['suffix'] ?>
                                        <input type="hidden" name="items[total][]" id="item_total">
                                    </td>

                                    <td class="text-right">
                                        <button class="btn btn-danger btn-sm btn-remove" type="button"><span class="fas fa-minus"></span></button>
                                    </td>
                                </tr>
                            </table>


                            <?= form_open(base_url('admin/sales/invoices/edit/'.$invoice['id'])); ?>
                                <div class="row">



                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?= __("Number") ?></label>
                                            <input type="text" class="form-control" name="number" value="<?= $invoice['number']; ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?php _e('Entity'); ?></label>
                                            <select class="form-control select2" name="entity_id" required>
                                                <?php foreach ($entities as $entity) { ?>
                                                    <option value="<?php echo $entity['id']; ?>" <?php if($invoice['entity_id'] == $entity['id']) echo "selected"; ?> ><?php echo $entity['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?php _e('Client'); ?></label>
                                            <select class="form-control select2_clients" name="client_id" required>
                                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?> - <?php echo $client['company_taxid']; ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?= __("Date") ?></label>
                                            <input type="text" class="form-control" name="date" id="datepicker" value="<?php echo date_display($invoice['date']); ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?= __("Due Date") ?></label>
                                            <input type="text" class="form-control" name="due_date" value="<?php echo date_display($invoice['due_date']); ?>" id="datepicker2" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?php _e('Agent'); ?></label>
                                            <select class="form-control select2" name="added_by" required>
                                                <?php foreach ($staff as $item) { ?>
                                                    <option value="<?php echo $item['id']; ?>" <?php if($invoice['added_by'] == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?php _e('Status'); ?></label>
                                            <select class="form-control select2" name="status" required>
                                                    <option value="Valid" <?php if($invoice['status'] == "Valid") echo "selected"; ?> ><?php _e('Valid'); ?></option>
                                                    <option value="Draft" <?php if($invoice['status'] == "Draft") echo "selected"; ?> ><?php _e('Draft'); ?></option>
                                                    <option value="Canceled" <?php if($invoice['status'] == "Canceled") echo "selected"; ?> ><?php _e('Canceled'); ?></option>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class=""><?php _e('Language'); ?></label>
                                            <select class="form-control select2" name="language_id" required>
                                                <?php foreach ($languages as $language) { ?>
                                                    <option value="<?php echo $language['id']; ?>" <?php if($invoice['language_id'] == $language['id']) echo "selected"; ?> ><?php echo $language['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>



                                    <?php if($currency['id'] == get_setting('default_currency')) { ?>
                                        <input type="hidden" name="rate" value="1" id="exrate">
                                    <?php } else { ?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class=""><?= __("Exchange Rate") ?></label>
                                                <input type="number" min="0" step="any" class="form-control" name="rate" id="exrate" value="<?= $invoice['rate'] ?>">
                                                <span class="help-block with-errors messages text-danger"></span>
                                            </div>
                                        </div>
                                    <?php } ?>




                                    <div class="col-md-12">

                                        <table class="table table-bordered controls" id="customDataTable">
                                            <thead>
                                                <tr>
                                                    <th class="th-width-32"><?= __("Item") ?></th>
                                                    <th class="th-width-25"><?= __("Description") ?></th>

                                                    <th class="th-width-8"><?= __("Quantity") ?></th>
                                                    <th class="th-width-20"><?= __("Price") ?></th>
                                                    <th class="th-width-8"><?= __("Tax Rate") ?></th>

                                                    <th><?= __("Value") ?></th>
                                                    <th><?= __("Tax") ?></th>
                                                    <th><?= __("Total") ?></th>
                                                    <th class="text-right th-width-5"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="entries">
                                                <?php foreach($invoice_items as $item) { ?>
                                                    <tr class="entry">
                                                        <td>

                                                            <input type="text" class="form-control" name="items[name][]" id="item_name" placeholder="<?= __("Item name") ?>" value="<?= $item['name']; ?>">

                                                            <input type="hidden" name="items[item_id][]" id="item_id" value="<?= $item['item_id']; ?>">
                                                            <input type="hidden" name="items[type][]" id="item_type" value="<?= $item['type']; ?>">



                                                        </td>


                                                        <td>
                                                            <input type="text" class="form-control" name="items[description][]" id="item_description" placeholder="<?= __("Item description") ?>" value="<?= $item['description']; ?>">
                                                        </td>


                                                        <td>
                                                            <input type="number" step="any" class="form-control onchange-update-totals" name="items[qty][]" id="item_qty" required  value="<?= $item['qty']; ?>">
                                                        </td>

                                                        <td>
                                                            <input type="number" step="any" class="form-control item_price onchange-update-totals" name="items[price][]" id="item_price" required  value="<?= $item['price']; ?>" >

                                                        </td>

                                                        <td>
                                                            <input type="number" step="any" min="0" max="100" class="form-control item_taxrate onchange-update-totals" name="items[taxrate][]" id="item_taxrate" required value="<?= $item['taxrate']; ?>">


                                                        </td>

                                                        <td>
                                                            <?= $currency['prefix'] ?><span id="text_value"><?= $item['value']; ?></span><?= $currency['suffix'] ?>
                                                            <input type="hidden" name="items[value][]" id="item_value" value="<?= $item['value']; ?>">
                                                        </td>

                                                        <td>
                                                            <?= $currency['prefix'] ?><span id="text_vat"><?= $item['tax']; ?></span><?= $currency['suffix'] ?>
                                                            <input type="hidden" name="items[tax][]" id="item_tax" value="<?= $item['tax']; ?>">
                                                        </td>

                                                        <td>
                                                            <?= $currency['prefix'] ?><span id="text_total"><?= $item['total']; ?></span><?= $currency['suffix'] ?>
                                                            <input type="hidden" name="items[total][]" id="item_total" value="<?= $item['total']; ?>">
                                                        </td>

                                                        <td class="text-right">
                                                            <button class="btn btn-danger btn-sm btn-remove" type="button"><span class="fas fa-minus"></span></button>
                                                        </td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5"><?= __("TOTALS") ?></th>

                                                    <th>
                                                        <?= $currency['prefix'] ?><span id="text_totals_value">0</span><?= $currency['suffix'] ?>
                                                        <input type="hidden" name="value" id="totals_value">
                                                    </th>
                                                    <th>
                                                        <?= $currency['prefix'] ?><span id="text_totals_tax">0</span><?= $currency['suffix'] ?>
                                                        <input type="hidden" name="tax" id="totals_tax">
                                                    </th>
                                                    <th>
                                                        <?= $currency['prefix'] ?><span id="text_totals_total">0</span><?= $currency['suffix'] ?>
                                                        <input type="hidden" name="total" id="totals_total">
                                                    </th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </tfoot>

                                        </table>


                                    </div>

                                    <div class="col-md-8">

                                        <div class="card sale-card border border-primary">
                                            <div class="card-header">
                                                <h5><?= __("Add manually") ?></h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="select2 form-control" name="manual_type" id="manual_type">
                                                                <option value="Service"><?= __("Service") ?></option>
                                                                <option value="Discount"><?= __("Discount (custom)") ?></option>
                                                                <option value="Discount_last"><?= __("Discount (last product)") ?></option>
                                                                <option value="Discount_all"><?= __("Discount (entire value)") ?></option>
                                                                <option value="Advance"><?= __("Advance") ?></option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="manual_name" id="manual_name" placeholder="<?= __("Item name") ?>">
                                                            <span class="help-block with-errors messages text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="manual_description" id="manual_description" placeholder="<?= __("Item description") ?>">
                                                            <span class="help-block with-errors messages text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="manual_taxrate" id="manual_taxrate" required>
                                                                <?php foreach ($taxrates as $taxrate) { ?>
                                                                    <option <?php if(get_setting('default_taxrate') == $taxrate['id']) echo 'selected'; ?> value="<?php echo $taxrate['rate']; ?>"><?php echo $taxrate['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <button class="btn btn-success btn-sm btn-add-manually" type="button"><span class="fas fa-plus"></span></button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-md-4">

                                        <div class="card sale-card border border-primary">
                                            <div class="card-header">
                                                <h5><?= __("Add predefined item") ?></h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <select class="form-control select2_items" name="predefined_id" id="predefined_id" >

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <button class="btn btn-success btn-sm btn-add-predefined" type="button"><span class="fas fa-plus"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>




                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Public Notes") ?></label>
                                            <textarea name="public_notes" class="form-control" id="tinymceinputX"><?php echo $invoice['public_notes']; ?></textarea>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Private Notes") ?></label>
                                            <textarea name="private_notes" class="form-control" id="tinymceinputX"><?php echo $invoice['private_notes']; ?></textarea>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <br>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Save Invoice") ?></button>
                                    </div>



                                </div>
                            <?= form_close(); ?>




                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>



<script type="text/javascript">







    $(document).ready(function() {





        update_totals();


        $('#manual_type').on('change', function (e) {
            var value = $("#manual_type").val();

            if(value == "Discount") {
                $("#manual_name").attr("placeholder", "<?= __("Discount Value") ?>");
            } else if(value == "Discount_all") {
                $("#manual_name").attr("placeholder", "<?= __("Discount percent") ?>");
            } else if(value == "Discount_last") {
                $("#manual_name").attr("placeholder", "<?= __("Discount percent") ?>");
            } else {
                $("#manual_name").attr("placeholder", "<?= __("Item name") ?>");
            }
        });





        $(document).on('click', '.btn-add-predefined', function(e)
        {
            // add new blank line
            var controlForm = $('.controls .entries:first');
            templateEntry = $('.templateEntry:first');
            newEntry = $(templateEntry.clone()).appendTo(controlForm);
            newEntry.removeClass('hidden').removeClass('templateEntry').addClass('entry');

            var itemId = $('#predefined_id').val();

            $.get( "<?= base_url('admin/sales/items/json_item/'); ?>"+itemId, function( data ) {

                var itemArr = JSON.parse(data);

                // populate entry
                $('.entries:last').find('#text_item_name:last').text(itemArr.name);
                $('.entries:last').find('#text_item_type:last').text(itemArr.type);
                $('.entries:last').find('#item_id:last').val(itemArr.id);
                $('.entries:last').find('#item_type:last').val(itemArr.type);
                $('.entries:last').find('#item_name:last').val(itemArr.name);

                $('.entries:last').find('#item_description:last').val("");
                $('.entries:last').find('#item_um:last').val(itemArr.um);
                $('.entries:last').find('#item_qty:last').val("1");
                $('.entries:last').find('#item_price:last').val( itemArr.price / $('#exrate').val() );
                $('.entries:last').find('#item_taxrate:last').val(itemArr.taxrate);

                update_totals();
            });


            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
  
            return false;
        });









    });
</script>
