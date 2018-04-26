<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '订单详情');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#"><?= \Yii::t('app', '订单管理');?></a></li>
        <li class="active"><?= \Yii::t('app', '订单详情');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="javascript:history.back(-1)" ><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box">
                    用户信息
                    <?php if(!empty($user)){?>
                        <div class="box-header row">
                            <div class="col-xs-3">
                                用户id:<?=$user['Uid']?>
                            </div>
                            <div class="col-xs-3">
                                用户名:<?=$user['UserName']?>
                            </div>
                            <div class="col-xs-3">
                                手机号:<?=$user['Mobile']?>
                            </div>
                            <div class="col-xs-3">
                                注册时间:<?=date('Y-m-d H:i:s',$user['Time'])?>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="box-header row">
                            <div class="col-xs-12">
                                <span style="color: red"><?= \Yii::t('app', '暂无用户信息');?></span>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="box">
                    收货信息
                    <?php if(!empty($receive)){?>
                        <div class="box-header row">
                            <div class="col-xs-3">
                                收货人姓名:<?=$receive['Name']?>
                            </div>
                            <div class="col-xs-3">
                                手机号码:<?=$receive['Mobile']?>
                            </div>
                        </div>
                        <div class="box-header row">
                            <div class="col-xs-12">
                                收货地址:<?=$receive['Province']?> <?=$receive['City']?> <?=$receive['Area']?> <?=$receive['Address']?>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="box-header row">
                            <div class="col-xs-12">
                                <span style="color: red"><?= \Yii::t('app', '暂无收货信息');?></span>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="box">
                    订单信息
                    <?php if(!empty($order)){?>
                        <div class="box-header row">
                            <div class="col-xs-3">
                                订单号:<?=$order['OrderId']?>
                            </div>
                            <div class="col-xs-3">
                                订单类型:<?=\common\enums\Order::labels()[\common\enums\Order::pfwvalues('TYPE')[$order['Type']]]?>
                            </div>
                            <div class="col-xs-3">
                                订单价格:<?=$order['Price']?>
                            </div>
                            <div class="col-xs-3">
                                发货状态:<?php $send = \common\enums\Order::labels()[\common\enums\Order::pfwvalues('SEND')[$order['SendStatus']]];
                                            if($order['SendStatus'] == 1){
                                                echo '<span style="color: green">'.$send.'</span>';
                                            }else{
                                                echo '<span style="color: red">'.$send.'</span>';
                                            }
                                        ?>
                            </div>
                            <div class="col-xs-3">
                                订单状态:<?php $status = \common\enums\Order::labels()[\common\enums\Order::pfwvalues('STATUS')[$order['Status']]];
                                            if($order['Status'] == 1){
                                                echo '<span style="color: green">'.$status.'</span>';
                                            }else{
                                                echo '<span style="color: red">'.$status.'</span>';
                                            }
                                        ?>
                            </div>
                            <div class="col-xs-3">
                                下单时间:<?=!empty($order['Time']) ? date('Y-m-d H:i:s',$order['Time']) : '';?>
                            </div>
                            <div class="col-xs-6">
                                退款时间:<?=!empty($order['RefundTime']) ? date('Y-m-d H:i:s',$order['RefundTime']) : '';?>
                            </div>
                            <div class="col-xs-12">
                                备注:<?=$order['Mark'];?>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="box-header row">
                            <div class="col-xs-12">
                                <span style="color: red"><?= \Yii::t('app', '暂无订单信息');?></span>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <?php if(!empty($orderDetail)){?>
                    <?php foreach ($orderDetail as $val){?>
                        <div class="box">
                            <div class="box-header row">
                                <div class="col-xs-3">
                                    课程id:<?=$val['CourseId']?>
                                </div>
                                <div class="col-xs-3">
                                    课程名称:<?=$val['ProdName']?>
                                </div>
                                <div class="col-xs-3">
                                    数量:<?=$val['Count']?>
                                </div>
                                <div class="col-xs-3">
                                    原价:<?=$val['Price']?>
                                </div>
                                <div class="col-xs-3">
                                    折扣价:<?=$val['DiscountPrice']?>
                                </div>
                                <div class="col-xs-3">
                                    是否试听:<?=$val['IsTry']?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php } ?>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->