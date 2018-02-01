<!-- Content Header (Page header) -->
<script language="javascript" type="text/javascript"
        src="/97date/WdatePicker.js"></script>
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '注册用户信息');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','home page')?></a></li>
        <li><a href="#"><?= \Yii::t('app','user management')?></a></li>
        <li class="active"><?= \Yii::t('app', 'registered user list');?></li>
    </ol>
</section>

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
                            <input type="hidden" name="r" value="user/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="UserName" class="form-control" placeholder="注册账号"
                                       value="<?=!empty($searchData['UserName'])?$searchData['UserName']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="ReadLevel" class="form-control" placeholder="水平测试等级"
                                       value="<?=!empty($searchData['ReadLevel'])?$searchData['ReadLevel']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Mobile" class="form-control" placeholder="联系电话"
                                       value="<?=!empty($searchData['Mobile'])?$searchData['Mobile']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="activated_time" class="form-control" placeholder="注册时间"
                                       value="<?=!empty($searchData['activated_time'])?$searchData['activated_time']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
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
                            <th>UID</th>
                            <th>注册账号</th>
                            <th>学员姓名</th>
                            <th>用户状态</th>
                            <th>联系电话</th>
                            <th>注册时间</th>
                            <th>年龄</th>
                            <th>城市</th>
                            <th>水平测试等级</th>
                            <th>调查问卷得分</th>
                            <th>学习状态</th>
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?php echo $user['Uid']?></td>
                                <td><?php echo $user['UserName']?></td>
                                <td><?php echo $user['EnName']?></td>
                                <td><?php echo $user['UserStatus']?></td>
                                <td><?php echo $user['Mobile']?></td>
                                <td><?php echo $user['Time']?></td>
                                <td><?php echo $user['Birthday']?></td>
                                <td><?php echo $user['City']?></td>
                                <td><?php echo $user['ReadLevel']?></td>
                                <td><?php echo $user['SurveyScore']?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-default" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=user/activate&id=123');"><i class="fa fa-edit"></i> 激活</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->