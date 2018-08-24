<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '用户课程');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','课程管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '用户课程');?></li>
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
                        <a class="btn btn-primary" href="?r=user-course/add"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="user-course/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="uid"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="HLevel" class="form-control" placeholder="课程等级"
                                       value="<?=!empty($searchData['HLevel'])?$searchData['HLevel']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select name="Course" class="form-control">
                                        <option value=''>课程</option>
                                    <?php foreach ($courseName as $key => $val): ?>
                                        <option <?php if($val['ID'] == $searchData['Course']) echo 'selected';?> value="<?=$val['ID']?>"><?=$val['ProdName']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <select name="id" class="form-control">
                                        <option value=''>直播课时间</option>
                                    <?php foreach ($liveTime as $key => $val): ?>
                                        <option <?php if($val['id'] == $searchData['id']) echo 'selected';?> value="<?=$val['id']?>"><?='L'.$val['level'].' 周'.$val['week'].' '.$val['time']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Time1" class="form-control" placeholder="购买时间"
                                       value="<?=!empty($searchData['Time1'])?$searchData['Time1']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                                --
                                <input type="text" name="Time2" class="form-control" placeholder="购买时间"
                                       value="<?=!empty($searchData['Time2'])?$searchData['Time2']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
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
                            <th>UID</th>
                            <th>注册账号</th>
                            <th>学员英文名</th>
                            <th>等级</th>
                            <th>课程</th>
                            <th>购买时间</th>
                            <th>选择直播课时间</th>
                        </tr>

                        <?php foreach($course as $user){?>
                            <tr>
                                <td><?php echo $user['Uid']?></td>
                                <td><?php echo $user['UserName']?></td>
                                <td><?php echo $user['EnName']?></td>
                                <td><?php echo $user['HLevel']?></td>
                                <td><?php echo $user['ProdName']?></td>
                                <td><?php echo date('Y-m-d H:i:s',$user['Time'])?></td>
                                <td><?php echo empty($user['week']) ? '暂未选择班级' : '周'.$user['week'].','.$user['live_time']?></td>
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