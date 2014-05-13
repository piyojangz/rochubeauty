

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pending shipping report
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Task pending</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-12 connectedSortable"> 
                <!-- Box (with bar chart) -->
                <div class="box box-body" id="loading-example">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button  onclick="load_payment_list();" class="btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                            <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /. tools -->
                        <i class="fa fa-shopping-cart"></i>

                        <h3 class="box-title">  Pending shipping list</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><strong>Order ID</strong></th>
                                    <th><strong>รายชื่อ</strong></th>
                                    <th><strong>ที่อยู่</strong></th>
                                    <th><strong>ORDER</strong></th>
                                    <th><strong>ราคารวม</strong></th>
                                    <th><strong>คอมเมนท์</strong></th>
                                    <th><strong>ดำเนินการ</strong></th>
                                </tr>
                            </thead>
                            <tbody id="payment_list">
                                <?php
                                $i = 1;
                                $totalprice = 0;
                                foreach ($get_order_summary as $row): $sumprice = 0;
                                    ?>

                                    <tr>
                                        <td><a href="#" onclick="load_order_detail('<?= $row->order_id ?>');"><?= $row->order_id ?></a></td>
                                        <td><?= $row->orders_ownername ?></td>
                                        <td><?= $row->orders_address . " , " . $row->orders_providename . " , " . $row->orders_zipcode ?></td>
                                        <td>
                                            <?php foreach ($this->order_model->get_order_summary_list($row->order_id) as $item): ?>
                                                <?php echo $item->title . "<b>(" . $item->qty . ")</b></BR>"; ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php foreach ($this->order_model->get_order_summary_detail($row->order_id) as $item): ?>
                                                <?php
                                                $txtqty = $item->qty;
                                                $pricepro = $item->pricepro;
                                                $pricepro3 = $item->pricepro3;
                                                $pricepro6 = $item->pricepro6;
                                                $pricepro12 = $item->pricepro12;
                                                if ($pricepro != 0) {
                                                    if ($txtqty < 3) {
                                                        $txtprice = $pricepro;
                                                    } elseif ($txtqty < 6) {
                                                        if ($pricepro3 == 0) {
                                                            $txtprice = $pricepro;
                                                        } else {
                                                            $txtprice = $pricepro3;
                                                        }
                                                    } elseif ($txtqty < 12) {
                                                        if ($pricepro6 == 0) {
                                                            $txtprice = $pricepro;
                                                        } else {
                                                            $txtprice = $pricepro6;
                                                        }
                                                    } else {

                                                        if ($pricepro12 == 0) {
                                                            $txtprice = $pricepro;
                                                        } else {
                                                            $txtprice = $pricepro12;
                                                        }
                                                    }
                                                } else {
                                                    $txtprice = $price;
                                                }
                                                $sumprice = $sumprice + $txtprice * $txtqty;
                                                ?>
                                            <?php endforeach; ?>
                                            <?php
                                            echo number_format($sumprice, 2, '.', ',');
                                            $totalprice = $totalprice + $sumprice;
                                            ?>
                                        </td>
                                        <td><?= $row->detail ?></td>
                                        <td><input type="submit" class="btn btn-primary" name="shipping" id="shipping" value="ยืนยันการจัดส่ง" onclick="shipping(<?= $row->order_id ?>)" /></td>


                                        </td>
                                    </tr> 
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->        




            </section><!-- /.Left col -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<!-- ORDER MODAL -->
<div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-shopping-cart"></i> Order <span>#9123213</span></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 table-responsive" id="order_detail_dection">


                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>

            <div class="modal-footer clearfix">

                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $(document).ready(function() {
        load_payment_list();
    });


    function shipping(id) {
        if (confirm('ยืนยีนการจัดส่งหรือไม่?')) {
            var $btn = $("#shipping" + id);
            $btn.button('loading');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/service/update_shipping_shortcut",
                data: {'id': id},
                dataType: "json",
                success: function(data) {

                    $.growl(data.status.message, {type: data.status.type}); //danger , info , warning
                    $btn.button('reset');
                    load_payment_list();

                },
                error: function(XMLHttpRequest) {
                    $.growl(XMLHttpRequest.status, {type: 'danger'}); //danger , info , warning
                    $btn.button('reset');
                }
            });
        }
    }
    function load_payment_list() {
        $('#payment_list').html('<tr><td colspan="7"><center><img src="<?php echo base_url(); ?>public/img/loading.gif"  width="50"/></center></td></tr>');
        setTimeout(
                function()
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "service/load_payment_list",
                        dataType: "html",
                        success: function(data) {

                            $('#payment_list').html(data);
                        },
                        error: function(XMLHttpRequest) {
                            console.log(XMLHttpRequest.status);
                        }
                    });
                }
        , 1000);
    }
</script>