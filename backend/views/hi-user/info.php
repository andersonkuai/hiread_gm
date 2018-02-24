<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '用户详情');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#"><?= \Yii::t('app', '用户管理');?></a></li>
        <li class="active"><?= \Yii::t('app', '用户详情');?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-default" href="?r=hi-user/index"><i class="fa fa-arrow-circle-o-left"></i> <?= \Yii::t('app', '返回');?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-header row">
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '学员姓名：');?><?php echo $user->EnName;?>
                    </div>
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '昵称：');?><?php echo $user->NickName;?>
                    </div>
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '联系电话：');?><?php echo $user->Mobile;?>
                    </div>
                </div>
                <div class="box-header row">
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '年龄：');?><?php echo ceil((time()-$user->Birthday)/(24*3600*365));?>
                    </div>
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '城市：');?><?php echo $user->City;?>
                    </div>
                    <div class="col-xs-3">
                        <?= \Yii::t('app', '地址：');?><?php echo $user->City;?>
                    </div>
                </div>
                <div class="box-header with-border">
                    <span style="font-weight: bold"><?= \Yii::t('app', '课程学习记录');?></span>
                </div>
                <div class="box-header with-border" style="margin-top: 50px">
                    <table class="table table-bordered" style="width: 80%;border: solid;border-width:2px">
                        <tr style="border-bottom: solid;border-width: 2px">
                            <th style="border-right: solid;border-width: 1px">SN</th>
                            <th style="border-right: solid;border-width: 1px"><?= \Yii::t('app', '问题');?></th>
                            <th style="border-right: solid;border-width: 1px"><?= \Yii::t('app', '答案');?></th>
                            <th style="border-right: solid;border-width: 1px"><?= \Yii::t('app', '分值');?></th>
                        </tr>
                        <?php if(!empty($research)) { ?>
                            <?php foreach($research as $val){?>
                                <tr style="border-bottom: solid;border-width: 2px">
                                    <td style="border-right: solid;border-width: 1px"><?=$val['ID']?></td>
                                    <td style="border-right: solid;border-width: 1px"><?=$val['Name']?></td>
                                    <td style="border-right: solid;border-width: 1px">
                                        <?php
                                            if(!empty($answer[$val['ID']])){
                                                foreach ($answer[$val['ID']] as $v){
                                                    echo explode('|',$val['Choice'])[$v - 1].'，';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td style="border-right: solid;border-width: 1px">
                                        <?php
                                        if(!empty($answer[$val['ID']])){
                                            $point = 0;
                                            foreach ($answer[$val['ID']] as $v){
                                                if(!empty($points[$val['ID']][$v])) $point += $points[$val['ID']][$v];
                                            }
                                            echo $point;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php }?>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->
<script type="text/javascript">
    <!--
    $(document).ready(function() {

        $('#myForm').ajaxForm({
            dataType:"json",
            success:function(data){
                alert(data.msg);
                if(data.code == 1){
                    location.href = location.href ;
                }
            }
        });

        UTILITY.UPLOAD.bind('.uploadBtn');
    });
    -->
</script>