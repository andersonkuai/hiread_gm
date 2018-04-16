<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '操作日志');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','日志管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '操作日志');?></li>
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
                            <input type="hidden" name="r" value="admin-log/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="route" class="form-control" placeholder="操作通道"
                                       value="<?=!empty($searchData['route'])?$searchData['route']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="ip" class="form-control" placeholder="ip"
                                       value="<?=!empty($searchData['ip'])?$searchData['ip']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="user_id" class="form-control" placeholder="用户id"
                                       value="<?=!empty($searchData['user_id'])?$searchData['user_id']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="user_name" class="form-control" placeholder="用户名"
                                       value="<?=!empty($searchData['user_name'])?$searchData['user_name']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="table" class="form-control" placeholder="表名"
                                       value="<?=!empty($searchData['table'])?$searchData['table']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="action">
                                    <option value="" >所有</option>
                                    <option value="insert" <?php if($searchData['action'] == 'insert') echo 'selected';?>>添加</option>
                                    <option value="update" <?php if($searchData['action'] == 'update') echo 'selected';?>>修改</option>
                                    <option value="delete" <?php if($searchData['action'] == 'delete') echo 'selected';?>>删除</option>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Time1" class="form-control" placeholder="操作时间"
                                       value="<?=!empty($searchData['Time1'])?$searchData['Time1']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
                                --
                                <input type="text" name="Time2" class="form-control" placeholder="操作时间"
                                       value="<?=!empty($searchData['Time2'])?$searchData['Time2']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
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
                            <th>用户id</th>
                            <th>用户名</th>
                            <th>操作通道</th>
                            <th>ip</th>
                            <th>表名</th>
                            <th>操作类型</th>
                            <th>具体信息</th>
                            <th>操作时间</th>
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?php echo $user['user_id']?></td>
                                <td><?php echo $user['user_name']?></td>
                                <td><?php echo $user['route']?></td>
                                <td><?php echo $user['ip']?></td>
                                <td><?php echo $user['table']?></td>
                                <td><?php
                                        switch ($user['action']){
                                            case 'insert':
                                                $str = "<span style='color: #00aa00;font-weight: bold'>添加</span>";
                                                break;
                                            case 'update':
                                                $str = "<span style='color: #f39a0d;font-weight: bold''>修改</span>";
                                                break;
                                            default;
                                                $str = "<span style='color: red;font-weight: bold''>删除</span>";
                                                break;
                                        }
                                        echo $str;
                                    ?>
                                </td>
                                <td><?php echo $user['description']?></td>
                                <td><?php echo date('Y-m-d H:i:s',$user['created_at'])?></td>
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
<script>
    function markBackGround(obj) {
        $('tr').css('background-color', '#ffffff')
        $(obj).parent().parent().parent().css('background-color', '#C6E746')
    }
</script>