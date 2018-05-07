<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '代金券列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','功能管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '代金券列表');?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=coupon/add"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="coupon/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Name" class="form-control" placeholder="代金券名称"
                                       value="<?=!empty($searchData['Name'])?$searchData['Name']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="Type" id="">
                                    <option value="">代金券类型</option>
                                    <?php
                                    foreach (\common\enums\Coupon::pfvalues('COUPON_TYPE') as $key => $obj){
                                        $selected = isset($searchData['Type']) && $searchData['Type'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Coupon::labels()[$key].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">查询</button>
                        </form>

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
<!--                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>-->
                            <th>代金券ID</th>
                            <th>代金券名称</th>
                            <th>类型</th>
                            <th>面值</th>
                            <th>有效期</th>
                            <th>操作</th>
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?php echo $user['ID']?></td>
                                <td><?php echo $user['Name']?></td>
                                <td>
                                    <?php
                                        echo \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_TYPE')[$user['Type']]];
                                    ?>
                                </td>
                                <td><?php echo $user['Price']?></td>
                                <td><?php echo $user['Expire']/(24*3600).'天'?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="?r=coupon/edit&id=<?php echo $user['ID']?>" target="_Blank">修改</a>&nbsp;&nbsp;
                                        <a class="" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=coupon/del&id=<?php echo $user['ID']?>');"><i class="fa fa-minus-square"></i> 删除</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->