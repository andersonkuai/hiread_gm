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
                        <a class="btn btn-primary" href="?r=order/create-order"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="order/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="<?= \Yii::t('app', '用户ID');?>"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="UserName" class="form-control" placeholder="<?= \Yii::t('app', '用户名');?>"
                                       value="<?=!empty($searchData['UserName'])?$searchData['UserName']:''?>">
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
                            <th><?= \Yii::t('app', '用户ID');?></th>
                            <th><?= \Yii::t('app', '用户名');?></th>
                            <th><?= \Yii::t('app', '支付链接');?></th>
                            <th><?= \Yii::t('app', '课程名称');?></th>
                            <th><?= \Yii::t('app', '课程ID');?></th>
                            <th><?= \Yii::t('app', '订单价格');?></th>
                            <th><?= \Yii::t('app', '折扣价');?></th>
                            <th><?= \Yii::t('app', '早鸟价');?></th>
                            <th><?= \Yii::t('app', '支付价格');?></th>
                            <th><?= \Yii::t('app', '下单时间');?></th>
                        </tr>
                        <?php if(!empty($orders)) foreach($orders as $val){?>
                            <tr>
<!--                                <td align="center"><input type="checkbox" name="checkids[]" value="--><?php //echo $val['OrderId'];?><!--"/></td>-->
                                <td><?php echo $val['OrderId']?></td>
                                <td><?php echo $val['Uid'];?></td>
                                <td><?php echo $val['UserName'];?></td>
                                <td><?php echo $val['PayLink']?></td>
                                <td><?php echo $val['ProdName']?></td>
                                <td><?php echo $val['CourseId']?></td>
                                <td><?php echo $val['coursePrice']?></td>
                                <td><?php echo $val['DiscountPrice']?></td>
                                <td><?php echo $val['earlyBirdPrice']?></td>
                                <td><?php echo $val['Price']?></td>
                                <td><?php if(!empty($val['CreateTime'])) echo date("Y-m-d H:i:s", $val['CreateTime'])?></td>
                            </tr>
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
</script>