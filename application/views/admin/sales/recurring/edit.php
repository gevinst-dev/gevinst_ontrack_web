<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header-title">
                    <i class="fas fa-retweet bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-right">







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

                                        <input type="text" class="form-control" name="items[name][]" id="item_name" placeholder="<?= __("Item name") ?>">


                                    </td>


                                    <td>
                                        <input type="text" class="form-control" name="items[description][]" id="item_description" placeholder="<?= __("Item description") ?>">
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control onchange-update-totals" name="items[qty][]" id="item_qty" required >
                                    </td>

                                    <td>
                                        <input type="number" step="any" class="form-control onchange-update-totals" name="items[price][]" id="item_price" required >

                                        <select class="form-control select2X" name="items[currency_id][]" id="item_currency" required>
                                            <?php foreach ($currencies as $item) { ?>
                                                <option value="<?php echo $item['id']; ?>"  ><?php echo $item['code']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" step="any" min="0" max="100" class="form-control onchange-update-totals" name="items[taxrate][]" id="item_taxrate" required >
                                    </td>

                                    <td>
                                        <span id="text_value"></span>
                                        <input type="hidden" name="items[value][]" id="item_value">
                                    </td>

                                    <td>
                                        <span id="text_vat"></span>
                                        <input type="hidden" name="items[tax][]" id="item_tax">
                                    </td>

                                    <td>
                                        <span id="text_total"></span>
                                        <input type="hidden" name="items[total][]" id="item_total">
                                    </td>

                                    <td class="text-right">
                                        <button class="btn btn-danger btn-sm btn-remove" type="button"><span class="fas fa-minus"></span></button>
                                    </td>
                                </tr>
                            </table>

                            <?= form_open(base_url('admin/sales/recurring/edit/'.$recurring['id'])); ?>
                                <div class="row">




                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Entity'); ?></label>
                                            <select class="form-control select2" name="entity_id" required>
                                                <?php foreach ($entities as $entity) { ?>
                                                    <option value="<?php echo $entity['id']; ?>" <?php if($recurring['entity_id'] == $entity['id']) echo "selected"; ?> ><?php echo $entity['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Type'); ?></label>
                                            <select class="form-control select2" name="type" required>
                                                <option value=""><?php _e('Plesae select'); ?></option>

                                                <option value="Invoice" <?php if($recurring['type'] == "Invoice") echo "selected"; ?> ><?php _e('Invoice'); ?></option>
                                                <option value="Proforma" <?php if($recurring['type'] == "Proforma") echo "selected"; ?> ><?php _e('Proforma'); ?></option>
                                                <option value="Order" <?php if($recurring['type'] == "Order") echo "selected"; ?> ><?php _e('Order'); ?></option>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Frequency'); ?></label>
                                            <select class="form-control select2" name="frequency" required>
                                                <option value=""><?php _e('Plesae select'); ?></option>

                                                <option value="Monthly" <?php if($recurring['frequency'] == "Monthly") echo "selected"; ?> ><?php _e('Monthly'); ?></option>
                                                <option value="Weekly" <?php if($recurring['frequency'] == "Weekly") echo "selected"; ?>><?php _e('Weekly'); ?></option>
                                                <option value="Daily" <?php if($recurring['frequency'] == "Daily") echo "selected"; ?> ><?php _e('Daily'); ?></option>
                                                <option value="At 2 Weeks" <?php if($recurring['frequency'] == "At 2 Weeks") echo "selected"; ?> ><?php _e('At 2 Weeks'); ?></option>
                                                <option value="At 2 Months" <?php if($recurring['frequency'] == "At 2 Months") echo "selected"; ?> ><?php _e('At 2 Months'); ?></option>
                                                <option value="At 3 Months" <?php if($recurring['frequency'] == "At 3 Months") echo "selected"; ?> ><?php _e('At 3 Months'); ?></option>
                                                <option value="At 6 Months" <?php if($recurring['frequency'] == "At 6 Months") echo "selected"; ?> ><?php _e('At 6 Months'); ?></option>
                                                <option value="Yearly" <?php if($recurring['frequency'] == "Yearly") echo "selected"; ?> ><?php _e('Yearly'); ?></option>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Client'); ?></label>
                                            <select class="form-control select2_clients" name="client_id" required>
                                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?> - <?php echo $client['company_taxid']; ?></option>

                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Next Date") ?></label>
                                            <input type="text" class="form-control" name="next_date" id="datepicker" value="<?php echo date_display($recurring['next_date']); ?>" required>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Due Days") ?></label>
                                            <input type="text" class="form-control" name="due_days" value="<?= $recurring['due_days'] ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Limit") ?></label>
                                            <input type="text" class="form-control" name="emission_limit" value="<?= $recurring['emission_limit'] ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                            <span class="help-block with-errors messages text-muted"><?= __("-1 for unlimited.") ?></span>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Agent'); ?></label>
                                            <select class="form-control select2" name="added_by" required>
                                                <?php foreach ($staff as $item) { ?>
                                                    <option value="<?php echo $item['id']; ?>" <?php if($recurring['added_by'] == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Currency'); ?></label>
                                            <select class="form-control select2" name="currency_id" required>
                                                <?php foreach ($currencies as $item) { ?>
                                                    <option value="<?php echo $item['id']; ?>" <?php if($recurring['currency_id'] == $item['id']) echo "selected"; ?> ><?php echo $item['code']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?php _e('Language'); ?></label>
                                            <select class="form-control select2" name="language_id" required>
                                                <?php foreach ($languages as $language) { ?>
                                                    <option value="<?php echo $language['id']; ?>" <?php if($recurring['language_id'] == $language['id']) echo "selected"; ?> ><?php echo $language['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>




                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Status") ?></label>
                                            <select class="select2 form-control" name="status" required>
                                                <option value="Draft" <?php if($recurring['status'] == "Draft") echo "selected"; ?> ><?= __("Draft") ?></option>
                                                <option value="Active" <?php if($recurring['status'] == "Active") echo "selected"; ?> ><?= __("Active") ?></option>
                                                <option value="Suspended" <?php if($recurring['status'] == "Suspended") echo "selected"; ?> ><?= __("Suspended") ?></option>
                                                <option value="Canceled" <?php if($recurring['status'] == "Canceled") echo "selected"; ?> ><?= __("Canceled") ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class=""><?= __("Send Email") ?></label>
                                            <select class="select2 form-control" name="send_email" required>
                                                <option value=""><?= __("Please Select") ?></option>
                                                <option value="1" <?php if($recurring['send_email'] == "1") echo "selected"; ?> ><?= __("Yes") ?></option>
                                                <option value="0" <?php if($recurring['send_email'] == "0") echo "selected"; ?> ><?= __("No") ?></option>

                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class=""><?= __("Name") ?></label>
                                            <input type="text" class="form-control" name="name" required value="<?= $recurring['name'] ?>">
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>




                                    <div class="col-md-12">

                                        <table class="table table-bordered controls" id="customDataTable">
                                            <thead>
                                                <tr>
                                                    <th class="th-width-25"><?= __("Item") ?></th>
                                                    <th class="th-width-25"><?= __("Description") ?></th>
                                                    <th class="th-width-8"><?= __("Quantity") ?></th>
                                                    <th class="th-width-15"><?= __("Price") ?></th>
                                                    <th class="th-width-8"><?= __("Tax Rate") ?></th>

                                                    <th><?= __("Value") ?></th>
                                                    <th><?= __("Tax") ?></th>
                                                    <th><?= __("Total") ?></th>
                                                    <th class="text-right th-width-5"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="entries">
                                                <?php foreach($recurring_items as $item) { ?>
                                                    <tr class="entry">
                                                        <td>

                                                            <input type="hidden" name="items[item_id][]" id="item_id" value="<?= $item['item_id']; ?>">
                                                            <input type="hidden" name="items[type][]" id="item_type" value="<?= $item['type']; ?>">

                                                            <input type="text" class="form-control" name="items[name][]" id="item_name" <?php if(!in_array($item['type'], ['Undefined', 'Discount'])) echo "readonly"; ?> value="<?= $item['name']; ?>">


                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control" name="items[description][]" id="item_description" placeholder="<?= __("Item description") ?>" value="<?= $item['description']; ?>">
                                                        </td>

                                                        <td>
                                                            <input type="number" step="any" class="form-control onchange-update-totals" name="items[qty][]" id="item_qty" required value="<?= $item['qty']; ?>">
                                                        </td>

                                                        <td>
                                                            <input type="number" step="any" class="form-control onchange-update-totals" name="items[price][]" id="item_price" required value="<?= $item['price']; ?>">

                                                            <select class="form-control select2X" name="items[currency_id][]" id="item_currency" required>
                                                                <?php foreach ($currencies as $curr) { ?>
                                                                    <option value="<?php echo $curr['id']; ?>" <?php if($item['currency_id'] == $curr['id']) echo "selected"; ?>  ><?php echo $curr['code']; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </td>

                                                        <td>
                                                            <input type="number" step="any" min="0" max="100" class="form-control onchange-update-totals" name="items[taxrate][]" id="item_taxrate" required value="<?= $item['taxrate']; ?>">
                                                        </td>

                                                        <td>
                                                            <span id="text_value"><?= $item['value']; ?></span>
                                                            <input type="hidden" name="items[value][]" id="item_value" value="<?= $item['value']; ?>">
                                                        </td>

                                                        <td>
                                                            <span id="text_vat"><?= $item['tax']; ?></span>
                                                            <input type="hidden" name="items[tax][]" id="item_tax" value="<?= $item['tax']; ?>">
                                                        </td>

                                                        <td>
                                                            <span id="text_total"><?= $item['total']; ?></span>
                                                            <input type="hidden" name="items[total][]" id="item_total" value="<?= $item['total']; ?>">
                                                        </td>

                                                        <td class="text-right">
                                                            <button class="btn btn-danger btn-sm btn-remove" type="button"><span class="fas fa-minus"></span></button>
                                                        </td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>


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

                                                                <option value="Services"><?= __("Services") ?></option>
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
                                                            <select class="form-control select2_items" name="predefined_id" id="predefined_id">

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
                                            <label class=""><?= __("Notes") ?></label>
                                            <textarea name="notes" class="form-control" id="tinymceinputX"><?php echo $recurring['notes']; ?></textarea>
                                            <span class="help-block with-errors messages text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <br>

                                        <button type="submit" class="btn btn-primary waves-effect waves-light "><?= __("Save Recurrence") ?></button>
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
                $('.entries:last').find('#item_name:last').attr('readonly', true);

                $('.entries:last').find('#item_description:last').val("");
                $('.entries:last').find('#item_um:last').val(itemArr.um);
                $('.entries:last').find('#item_qty:last').val("1");
                $('.entries:last').find('#item_price:last').val(itemArr.price);
                $('.entries:last').find('#item_taxrate:last').val(itemArr.taxrate);

                update_totals();
            });


            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
    
            return false;
        });









    });
</script>
