<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use bburim\daterangepicker\DateRangePicker as DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PackagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-handshake-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total buyers</span>
                <span class="info-box-number"><?php echo $buyers?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Sellers</span>
                <span class="info-box-number"><?php echo $sellers ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Subscribe Sellers</span>
                <span class="info-box-number"><?php echo $subscribe_sellers ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Transaction Value</span>
                <span class="info-box-number"><small>$&nbsp;</small><?php if(isset($total_transactions_value)) { echo $total_transactions_value; }else{ echo '0';} ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-exchange"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Confirmed Transaction</span>
                <span class="info-box-number"><?php echo $accepted_carts  ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Confirmed Transaction Value</span>
                <span class="info-box-number"><small>$&nbsp;</small><?php if(isset($accepted_carts_value)) { echo $accepted_carts_value; }else{ echo '0';} ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class=" fa fa-image"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Images</span>
                <span class="info-box-number"><?php echo $total_images?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-product-hunt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Products</span>
                <span class="info-box-number"><?php echo $total_products ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Transaction</span>
                <span class="info-box-number"><?php echo $total_transactions ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box-body" style="background: #fff;">
            <h4>Top 100 Products</h4>
        <table class="table table-bordered">
            <tbody><tr>
                <th>No.</th>
                <th>Brand</th>
                <th>Part Number</th>
                <th>Secondary Part Number</th>
            </tr>
            <?php if(!empty($mostsoldproducts)){
                $i = 1;
             foreach ($mostsoldproducts as $mostsoldproduct){
                ?>
            <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $mostsoldproduct['brand'];?></td>

                <td><?php echo $mostsoldproduct['part_number'];?></td>
                <td><?php echo $mostsoldproduct['secondary_part_number'];?></td>

            </tr>
            <?php } } ?>
            </tbody></table>
            </div>
    </div>


</div>