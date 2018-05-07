<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?=\Yii::t('app','机构列表')?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?=\Yii::t('app','主页')?></a></li>
        <li><a href="#"><?=\Yii::t('app','推广管理')?></a></li>
        <li class="active"><?=\Yii::t('app','机构列表')?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=gl-auth/user-add"><i class="fa fa-plus"></i> <?=\Yii::t('app','添加')?></a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="coupon/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="username" class="form-control" placeholder="账户"
                                       value="<?=!empty($searchData['username'])?$searchData['username']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="mark" class="form-control" placeholder="备注"
                                       value="<?=!empty($searchData['mark'])?$searchData['mark']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="Type" id="">
                                    <option value="">账户类型</option>
                                    <?php
                                    foreach (\common\enums\Generalize::pfvalues('USER_TYPE') as $key => $obj){
                                        $selected = isset($searchData['type']) && $searchData['type'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Generalize::labels()[$key].'</option>';
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
                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>
                            <th>ID</th>
                            <th><?=\Yii::t('app','账户')?></th>
                            <th><?=\Yii::t('app','备注')?></th>
                            <th><?=\Yii::t('app','账户类型')?></th>
                            <th><?=\Yii::t('app','创建时间')?></th>
                            <th><?=\Yii::t('app','最后登录时间')?></th>
                            <th><?=\Yii::t('app','状态')?></th>
                            <th><?=\Yii::t('app','操作')?></th>
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td align="center"><input type="checkbox" name="checkids[]" value="<?php echo $user->id;?>"/></td>
                                <td><?php echo $user->id?></td>
                                <td><?php echo $user->username?></td>
                                <td><?php echo $user->mark?></td>
                                <td>

                                    <?php echo \common\enums\Generalize::labels()[\common\enums\Generalize::pfwvalues('USER_TYPE')[$user->type]]?>
                                </td>
                                <td><?php echo date("Y-m-d", $user->created)?></td>
                                <td><?php echo date("Y-m-d H:i:s", $user->login_time)?></td>
                                <td>
                                    <?php if($user->status == 10){ ?>
                                    <span class="label label-success"><?=\Yii::t('app','正常')?></span>
                                    <?php }else{?>
                                    <span class="label label-danger"><?=\Yii::t('app','禁用')?></span>
                                    <?php }?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="/index.php?r=auth/user-edit&id=<?php echo $user->id?>"><i class="fa fa-edit"></i> <?=\Yii::t('app','编辑')?></a>
                                        <a class="btn btn-default" href="javascript:void(0);" onclick="UTILITY.OPERATE.get('?r=auth/user-delete&id=<?php echo $user->id?>');"><i class="fa fa-trash-o"></i> <?=\Yii::t('app','删除')?></a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=auth/user-status&status=0', '<?=\Yii::t('app','确定禁用？')?>');"><?=\Yii::t('app','禁用')?></button>
                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=auth/user-status&status=10', '<?=\Yii::t('app','确定解除禁用？')?>');"><?=\Yii::t('app','解禁')?></button>
                    </div>
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->