<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '订单列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app', '主页');?></a></li>
        <li><a href="#"><?= \Yii::t('app', '订单管理');?></a></li>
        <li class="active"><?= \Yii::t('app', '订单列表');?></li>
    </ol>
</section>
<style type="text/css">
    a:link {
        color:#3C3C3C;
        text-decoration:none;
    }
    a:visited {
        color:#0000FF;
        text-decoration:none;
    }
    a:hover {
        color:#FF00FF;
        text-decoration:none;
    }
    a:active {
        color:#D200D2;
        text-decoration:none;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <a class="btn btn-primary" href="?r=user/add"><i class="fa fa-plus"></i> 添加</a>-->
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="order/list">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="<?= \Yii::t('app', '用户ID');?>"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="UserName" class="form-control" placeholder="<?= \Yii::t('app', '用户名');?>"
                                       value="<?=!empty($searchData['UserName'])?$searchData['UserName']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Mobile" class="form-control" placeholder="<?= \Yii::t('app', '手机号');?>"
                                       value="<?=!empty($searchData['Mobile'])?$searchData['Mobile']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="Type" id="">
                                    <option value="" ><?= \Yii::t('app', '订单类型');?></option>
                                    <?php
                                    foreach (\common\enums\Order::pfvalues('TYPE') as $key => $obj){
                                        $selected = isset($searchData['Type']) && $searchData['Type'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Order::labels()[$key].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="PayType" id="">
                                    <option value="" ><?= \Yii::t('app', '支付方式');?></option>
                                    <?php
                                        foreach (\common\enums\Order::pfvalues('PAY_TYPE') as $key => $obj){
                                            $selected = isset($searchData['PayType']) && $searchData['PayType'] == $obj->getValue()
                                                ? 'selected="selected"':'';
                                            echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Order::labels()[$key].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="Status" id="">
                                    <option value="" ><?= \Yii::t('app', '订单状态');?></option>
                                    <?php
                                    foreach (\common\enums\Order::pfvalues('STATUS') as $key => $obj){
                                        $selected = isset($searchData['Status']) && $searchData['Status'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Order::labels()[$key].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="SendStatus" id="">
                                    <option value="" ><?= \Yii::t('app', '发货状态');?></option>
                                    <?php
                                    foreach (\common\enums\Order::pfvalues('SEND') as $key => $obj){
                                        $selected = isset($searchData['SendStatus']) && $searchData['SendStatus'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Order::labels()[$key].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Time1" class="form-control" placeholder="<?= \Yii::t('app', '下单时间');?>"
                                       value="<?=!empty($searchData['Time1'])?$searchData['Time1']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
                                --
                                <input type="text" name="Time2" class="form-control" placeholder="<?= \Yii::t('app', '下单时间');?>"
                                       value="<?=!empty($searchData['Time2'])?$searchData['Time2']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><?= \Yii::t('app', '搜索');?></button>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
<!--                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>-->
                            <th><?= \Yii::t('app', '订单号');?></th>
                            <th><?= \Yii::t('app', '订单类型');?></th>
                            <th><?= \Yii::t('app', '用户ID');?></th>
                            <th><?= \Yii::t('app', '用户名');?></th>
                            <th><?= \Yii::t('app', '手机号');?></th>
                            <th><?= \Yii::t('app', '邀请码');?></th>
                            <th><?= \Yii::t('app', '订单价格');?></th>
                            <th><?= \Yii::t('app', '订单状态');?></th>
                            <th><?= \Yii::t('app', '支付方式');?></th>
                            <th><?= \Yii::t('app', '第三方交易号');?></th>
                            <th><?= \Yii::t('app', '发货状态');?></th>
                            <th><?= \Yii::t('app', '订单生成时间');?></th>
                            <th><?= \Yii::t('app', '支付时间');?></th>
                            <th><?= \Yii::t('app', '退款时间');?></th>
                            <th><?= \Yii::t('app', '操作');?></th>
                        </tr>
                        <?php if(!empty($orders)) foreach($orders as $val){?>
                            <tr onclick="showDetail('<?=$val['OrderId'];?>')">
<!--                                <td align="center"><input type="checkbox" name="checkids[]" value="--><?php //echo $val['OrderId'];?><!--"/></td>-->
                                <td><?php echo $val['OrderId']?></td>
                                <td><?php echo \common\enums\Order::labels()[\common\enums\Order::pfwvalues('TYPE')[$val['Type']]];?></td>
                                <td><?php echo $val['Uid']?></td>
                                <td><?php echo $val['UserName']?></td>
                                <td><?php echo $val['Mobile']?></td>
                                <td><?php echo $val['InviteCode']?></td>
                                <td><?php echo $val['Price']?></td>
                                <td><?php $status = \common\enums\Order::labels()[\common\enums\Order::pfwvalues('STATUS')[$val['Status']]];if($val['Status'] == 1){
                                        echo '<span style="color: green">'.$status.'</span>';
                                    }else{
                                        echo '<span style="color: red">'.$status.'</span>';
                                    }?></td>
                                <td><?php echo \common\enums\Order::labels()[\common\enums\Order::pfwvalues('PAY_TYPE')[$val['PayType']]]?></td>
                                <td><?php echo $val['Trade'];?></td>
                                <td><?php $send = \common\enums\Order::labels()[\common\enums\Order::pfwvalues('SEND')[$val['SendStatus']]];if($val['SendStatus'] == 1){
                                echo '<span style="color: green">'.$send.'</span>';
                                }else{
                                echo '<span style="color: red">'.$send.'</span>';
                                }?></td>
                                <td><?php echo date("Y-m-d H:i:s", $val['Time'])?></td>
                                <td><?php if(!empty($val['PayTime'])) echo date("Y-m-d H:i:s", $val['PayTime'])?></td>
                                <td><?php if(!empty($val['RefundTime'])) echo date("Y-m-d H:i:s", $val['RefundTime'])?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a onclick="markBackGround(this)" href="?r=order/info&OrderId=<?php echo $val['OrderId']?>">详情</a>
                                        <!--                                        <a class="btn btn-default" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=user/activate&id=123');"><i class="fa fa-edit"></i> 激活</a>-->
                                    </div>
                                </td>
                            </tr>
                            <?php if(!empty($val['detail'])){ ?>
                            <tr class="<?=$val['OrderId'];?>" style="background-color: #f5f3e5;display: none;">
                                <th>课程id</th>
                                <th colspan="3">课程名称</th>
                                <th>数量</th>
                                <th>原价</th>
                                <th>折扣价</th>
                                <th>是否试听</th>
                            </tr>
                                <?php foreach ($val['detail'] as $v){?>
                                    <tr class="<?=$val['OrderId'];?>" style="background-color: #f5f3e5;display: none;">
                                        <td><?=$v['CourseId'];?></td>
                                        <td colspan="3"><?=$v['ProdName'];?></td>
                                        <td><?=$v['Count'];?></td>
                                        <td><?=$v['Price'];?></td>
                                        <td><?=$v['DiscountPrice'];?></td>
                                        <td><?=$v['IsTry'] == 1 ? '是':'否'?></td>
                                    </tr>
                                <?php }?>
                            <?php } ?>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
<!--                    <div class="btn-group btn-group-sm" role="group">-->
<!--                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=0', '确定禁用？');">禁用</button>-->
<!--                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=10', '确定解禁？');">解禁</button>-->
<!--                    </div>-->
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    function markBackGround(obj) {
//        $('tr').css('background-color', '#ffffff')
//        $(obj).parent().parent().parent().css('background-color', '#C6E746')
    }
    function showDetail(orderId) {
        $("."+orderId).toggle();
    }
</script>