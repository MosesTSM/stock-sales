<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class=" col-xs-12 col-sm-12 col-lg-12">

                <div id="messages"></div>
                <div id="loader_page">
                    <a>Uploading Products... </a>
                </div>
                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-error alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="box-header-over">
                    <div class="box-header">
                        <h3 class="box-title">Edit Discount</h3>
                    </div>

                    <form role="form" action="<?php base_url('discounts/update') ?>" method="post" class="form-horizontal">
                        <div class="main-box-body">
                            <div class="box-body">
                                <?php echo validation_errors(); ?>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Add Products</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">

                                        <h4>GENERAL INFO</h4>
                                        <div class="row padding-row ">
                                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                                <a>Date</a>
                                                <input type="text" class="form-control" disabled id="doc_date" name="doc_date" placeholder="Data" autocomplete="off" value="<?php echo $discount_header['doc_date']; ?>" disabled>
                                            </div>
                                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                                <a>Time</a>
                                                <input type="text" class="form-control" disabled id="doc_time" name="doc_time" placeholder="Time" autocomplete="off" value="<?php echo $discount_header['doc_time']; ?>" disabled>
                                            </div>
                                            <div class="col-xs-6 col-sm-4 col-lg-4">
                                                <a>Number</a>
                                                <input type="text" class="form-control" disabled id="doc_number" name="doc_number" placeholder="0000000" autocomplete="off" value="<?php echo $discount_header['id']; ?>" disabled>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" id="doc_date_doc_time" name="doc_date_doc_time" value="<?php echo $discount_header['doc_date_doc_time']; ?>" autocomplete="off">

                                        <div class="row padding-row">
                                            <div class=" col-xs-12 col-sm-4 col-lg-6">
                                                <a for=" customername">Discount Name</a>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Discount Name" autocomplete="off" value="<?php echo $discount_header['name']; ?>">
                                            </div>
                                            <div class=" col-xs-6 col-sm-4 col-lg-3">
                                                <a for=" tax_id">Start Date</a>
                                                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start Date" autocomplete="off" value="<?php echo $discount_header['start_date']; ?>">
                                            </div>
                                            <div class=" col-xs-6 col-sm-4 col-lg-3">
                                                <a>End Date</a>
                                                <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End Date" autocomplete="off" value="<?php echo $discount_header['end_date']; ?>">
                                            </div>
                                        </div>

                                        <div class="row padding-row">
                                            <div class=" col-xs-12 col-sm-4 col-lg-2">
                                                <a for=" customername">Min. Amount</a>
                                                <input type="text" onkeypress=validateNumber(event); class="form-control" id="band_start" name="band_start" placeholder="Min. Amount" autocomplete="off" value="<?php echo $discount_header['band_start']; ?>">
                                            </div>
                                            <div class=" col-xs-6 col-sm-4 col-lg-2">
                                                <a for=" tax_id">Max. Amount</a>
                                                <input type="text" onkeypress=validateNumber(event); class="form-control" id="band_end" name="band_end" placeholder="Max. Amount" autocomplete="off" value="<?php echo $discount_header['band_end']; ?>">
                                            </div>

                                            <div class=" col-xs-6 col-sm-3 col-lg-1">
                                                <a for="enumstypediscount">Discount Type</a><br>
                                                <select class="form-control select_group" id="type_discount" name="type_discount">
                                                    <option value="<?php echo $discount_header['type_discount'] ?>">
                                                        <?php echo $discount_header['type_discount'] ?></option>
                                                </select>
                                            </div>

                                            <div class=" col-xs-6 col-sm-8 col-lg-2">
                                                <a>Amount</a>
                                                <input type="text" onkeypress=validateNumber(event); class="form-control" id="amount" name="amount" placeholder="Amount" autocomplete="off" value="<?php echo $discount_header['amount']; ?>">
                                            </div>
                                            <div class=" col-xs-6 col-sm-4 col-lg-2">
                                                <a for="brands">Priority</a><br>
                                                <select class="form-control select_group" id="priority" name="priority">
                                                    <option value="<?php echo $discount_header['priority_id'] ?>">
                                                        <?php echo $discount_header['priority_id'] ?></option>
                                                </select>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-lg-3">
                                                <a for="brands">Currency</a><br>
                                                <select class="form-control select_group" id="currency_id" name="currency_id" required>
                                                    <option value="" selected disabled hidden>Select here</option>
                                                    <?php foreach ($currencies as $k => $v) : ?>
                                                        <option value="<?php echo $v['id'] ?>" <?php if ($discount_header['currency_id'] == $v['id']) {
                                                                                                    echo "selected='selected'";
                                                                                                } ?>><?php echo $v['name'] ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <div class=" ">
                                            <h4 class="box-title">ADD PRODUCTS</h4>
                                        </div>
                                        <div class="row padding-row ">
                                            <div class="col-xs-12 col-sm-12 col-lg-3 group-selection padding-row">
                                                <a>Category</a>
                                                <select class="form-control select_group" id="category" name="category">
                                                    <?php foreach ($category as $k => $v) : ?>
                                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-7 col-sm-7 col-lg-2">
                                                <br>
                                                <a id='fill_all_products' onClick="fillDocTableByCategory()" class="btn btn-primary-item-form ">FILL BY CATEGORY</a>
                                            </div>
                                        </div>

                                        <div class="row padding-row ">
                                            <div class="col-xs-12 col-sm-6 col-lg-5 padding-row">

                                                <table id="selecetTable" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:7%">ID</th>
                                                            <th>Product Name</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-lg-5 padding-row">

                                                <table id="optionsProductTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:7%">ID</th>
                                                            <th>Options</th>
                                                            <th>Part#</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="add_product">
                                            <div class="col-xs-12 col-sm-6 col-lg-5" id="messages_add_product">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row padding-row dashed-line">
                                    <div class="col-xs-5 col-sm-5 col-lg-10">
                                        <h4>APPLY TO SPECIFIC PRODUCT</h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-7 col-lg-2">
                                        <a id='fill_all_products' onClick="fillDocTableAllProducts()" class="btn btn-primary-item-form ">FILL BY ALL PRODUCTS</a>
                                    </div>
                                </div>
                                <div class="rcol-xs-12 col-sm-12 col-lg-12">
                                    <table id="docTable" class="table table-bordered ">
                                        <thead>
                                            <tr class="row">
                                                <th class="hidden-xs col-sm-2 col-lg-2">ID </th>
                                                <th class="hidden-xs col-xs-12 col-sm-5 col-lg-6 name-product-item-table">Product Name</th>
                                                <th class="hidden-xs col-xs-12 col-sm-2 col-lg-2">Option </th>
                                                <th class="hidden-xs  col-xs-2 col-sm-2 col-lg-2"></th>
                                                <th class="hidden-xs"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($list_products['data'])) : ?>
                                                <?php $x = 0; ?>
                                                <?php foreach ($list_products['data'] as $key => $val) : ?>
                                                    <?php
                                                    ?>
                                                    <tr class="row" id="row_<?php echo $x; ?>">
                                                        <td>
                                                            <input id="idProduct<?php echo $val['idProduct']; ?>" type="number" readonly class="form-control" name="product[]" value="<?php echo $val['idProduct'] ?>">
                                                        </td>
                                                        <td>
                                                            <a class="visible-xs">Name product</a>
                                                            <?php echo $val['nameProduct']; ?>
                                                        </td>
                                                        <td>
                                                            <a class="visible-xs">Option</a>
                                                            <input type="text" readonly class="form-control" name="option[]" value="<?php echo $val['nameOption'] ?>">
                                                        </td>

                                                        <td>
                                                            <button type="button" class="label-base-icon-doc remove-doc" onclick="removeRow('<?php echo $x; ?>')"></button>
                                                        </td>
                                                        <td>
                                                            <input id="idOption<?php echo  $val['idOption']; ?>" type="hidden" readonly class="form-control" name="attribute_id[]" value="<?php echo $val['idOption'] ?>">
                                                        </td>
                                                    </tr>
                                                    <?php $x++; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a>User name</a><br>
                            <?php echo $discount_header['username'] ?>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save Discount</button>
                                <a href="<?php echo base_url('discounts/') ?>" class="btn btn-warning">Back</a>
                            </div>
                    </form>
                </div>
            </div>
    </section>
</div>

<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var selecetTable;
    var docTable;
    var idProduct = -1;
    var editor;
    var row_id = 0;
    var it_count = 0;
    var dataProducts;
    var remove_action_row;
    var spinner;

    $(document).ready(function() {
        $('#category').change(function() { //button filter event click
            it_count = document.getElementById("docTable").rows.length;
            selecetTable.ajax.reload();
            if (optionsProductTable.data().count() > 0) {
                optionsProductTable.clear();
                optionsProductTable.draw();
            }
        });

        spinner = $('#loader_page');
        spinner.hide();

        $(".select_group").select2();
        selecetTable = $('#selecetTable').DataTable({
            language: {
                search: "",
                sLengthMenu: "_MENU_",
                searchPlaceholder: "SEARCH"
            },
            "scrollY": 300,
            "scrollX": false,
            "pageLength": 25,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('discounts/fetchAddProductTable') ?>",
                "type": "POST",
                "data": function(data) {
                    data.category = $("#category").val();
                }
            },
        });

        optionsProductTable = $('#optionsProductTable').DataTable({
            language: {
                search: "",
                sLengthMenu: "_MENU_",
                searchPlaceholder: "SEARCH"
            },
            "scrollY": 300,
            "scrollX": false,
            "pageLength": 25,
            "order": [], //Initial no order.
            "ajax": {
                "url": "<?php echo site_url('discounts/fetchAddAttributeTable') ?>",
                "type": "POST",
                "data": function(data) {
                    data.product_id = idProduct;
                }
            },
        });

        docTable = $('#docTable').DataTable({
            "scrollY": 480,
            "scrollX": false,
            "pageLength": 25,
            language: {
                search: "",
                sLengthMenu: "_MENU_",
                searchPlaceholder: "SEARCH"
            },
            "columns": [{
                    className: "hidden-xs col-sm-2 col-lg-2"
                },
                {
                    className: "col-xs-12 col-sm-6 col-lg-6 name-product-item-table"
                },
                {
                    className: "col-xs-10 col-sm-2 col-lg-2"
                },
                {
                    className: "col-xs-2 col-sm-2 col-lg-2"
                },
                {
                    className: "hidden-xs"
                }
            ]
        });

        $('#selecetTable tbody').on('click', 'tr', function() {
            dataProducts = selecetTable.row(this).data();
            if (dataProducts) {
                idProduct = dataProducts[0];
                optionsProductTable.ajax.reload();
                $("#selecetTable tbody tr").removeClass('row_selected');
                $(this).addClass('row_selected');
                $("#messages_add_product").hide(); //just reload table
            }
        });

        $('#optionsProductTable tbody').on('dblclick', 'tr', function() {
            var dataOptions = optionsProductTable.row(this).data();

            optionsProductTable.ajax.reload(); //just reload table

            if (dataOptions && dataProducts) {
                var arrayInfoProduct = {
                    'nameProduct': dataProducts[1],
                    'idProduct': dataProducts[0],
                    "nameOption": dataOptions[1],
                    "idOption": dataOptions[0],
                    "it_count": it_count
                };
                var id_item = arrayInfoProduct['idProduct'] + ',' + arrayInfoProduct['idOption'];
                var full_name = arrayInfoProduct['nameProduct'] + ' ' + arrayInfoProduct['nameOption'];

                var id_product_table = $("#idProduct" + arrayInfoProduct['idProduct']).val();
                var id_option_table = $("#idOption" + arrayInfoProduct['idOption']).val();
                var id_table = id_product_table + ',' + id_option_table;

                if (id_item == id_table) {
                    messages_add_product('This item ' + full_name + ' is already in the table!', 1);
                } else {
                    addRowToTable(arrayInfoProduct);
                    messages_add_product('This item ' + full_name + ' is added in the table!', 0);
                }
                $("#messages_add_product").show();
            } else {
                alert('Something is wrong!');
            }
        });

        $('#docTable tbody').on('click', 'tr', function() {
            idx = docTable.row(this).index();
            if (remove_action_row) {
                docTable.row(idx).remove().draw();
                remove_action_row = false;
            }
        });
    });

    function addRowToTable(dataInfo) {
        var nameProduct = dataInfo['nameProduct'];
        var idProduct = dataInfo['idProduct'];
        var nameOption = dataInfo['nameOption'];
        var idOption = dataInfo['idOption'];

        var rowNode = docTable.row.add([
            '<input id = "idProduct' + idProduct +
            '" type="number" readonly class="form-control" name="product[]" value="' + idProduct + '">',
            nameProduct,
            '<input type="text" readonly class="form-control" name="option[]" value="' + nameOption + '">',
            '<button type="button" class="label-base-icon-doc remove-doc" onclick="removeRow(\'' + it_count +
            '\')" ></button>',
            '<input id = "idOption' + idOption +
            '" type="hidden" readonly class="form-control" name="attribute_id[]" value="' + idOption + '">',
        ]).draw().node();

        $(rowNode).addClass("row");
        $(rowNode).attr("id", "row_" + it_count);
        it_count++;
    }

    function messages_add_product(message, status_message) {
        if (status_message == 0) {
            $("#messages_add_product").html('<div class="alert alert-info" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + message +
                '</div>');
        } else {
            $("#messages_add_product").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + message +
                '</div>');
        }
    }

    function show_message(message, status_message) {
        if (status_message == 0) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + message +
                '</div>');
        } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + message +
                '</div>');
        }
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    function fillDocTableAllProducts() {
        spinner.show();
        docTable
            .clear()
            .draw();
        $.ajax({
            url: "<?php echo site_url('discounts/fillDocTableAllProducts') ?>",
            type: "POST",
            data: "",
            dataType: 'json',
            error: function(request, error) {
                alert("Something is wrong! ( " + request.responseText + " )");
                spinner.hide();
            },
            success: function(response) {
                var dataArray = response["data"];
                var arrayLength = dataArray.length;
                for (var i = 0; i < arrayLength; i++) {
                    addRowToTable(dataArray[i]);
                }
                show_message("Done", 0);
                spinner.hide();
            }
        });
    }

    function fillDocTableByCategory() {
        var category = $("#category").val();
        spinner.show();
        docTable
            .clear()
            .draw();
        $.ajax({
            url: "<?php echo site_url('discounts/fillDocTableByCategory') ?>",
            type: "POST",
            data: {
                category_id: category,
            },
            dataType: 'json',
            error: function(request, error) {
                alert("Something is wrong! ( " + request.responseText + " )");
                spinner.hide();
            },
            success: function(response) {
                var dataArray = response["data"];
                var arrayLength = dataArray.length;
                for (var i = 0; i < arrayLength; i++) {
                    addRowToTable(dataArray[i]);
                }
                show_message("Done", 0);
                spinner.hide();
            }
        });
    }

    function removeRow(id) {
        remove_action_row = true;
    }

    function to_submit() {
        const array_fields = []
        var error = "";
        array_fields.push('name');
        array_fields.push('currency_id');
        array_fields.push('band_start');
        array_fields.push('band_end');
        array_fields.push('end_date');
        array_fields.push('start_date');
        array_fields.push('amount');

        var tableProductLength = $("#docTable tbody tr").length;
        if (!docTable.data().any()) {
            error += "Table is empty!";
            show_message(error);
            return false;
        }

        array_empty_fields = checkEmptyFields(array_fields);

        if (array_empty_fields.length > 0) {
            error += " \nThere are several empty fields ! (" + array_empty_fields + ")";
        }
        if (!error == '') {
            show_message(error);
            return false;
        }
    }

    function checkEmptyFields(arr_fields) {
        const array_empty_fields = []
        for (const field of arr_fields) {
            value = $("#" + field).val();

            if (value == 0 || value == null || value == '') {
                array_empty_fields.push(field);
            }
        }
        return array_empty_fields;
    }
</script>