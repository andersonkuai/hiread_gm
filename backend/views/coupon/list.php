<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '用户优惠券列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','功能管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '用户优惠券列表');?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
<!--                        <a class="btn btn-primary" href="?r=coupon/add"><i class="fa fa-plus"></i> 添加</a>-->
                    </div>
                    <form action="" method="get" class="form-inline">
                        <div class="box-tools">
                            <input type="hidden" name="r" value="coupon/list">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="用户ID"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="UserName" class="form-control" placeholder="用户名"
                                       value="<?=!empty($searchData['UserName'])?$searchData['UserName']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Coupon" class="form-control" placeholder="优惠券ID"
                                       value="<?=!empty($searchData['Coupon'])?$searchData['Coupon']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Name" class="form-control" placeholder="优惠券名称"
                                       value="<?=!empty($searchData['Name'])?$searchData['Name']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="Type" id="">
                                    <option value="">优惠券类型</option>
                                    <?php
                                    foreach (\common\enums\Coupon::pfvalues('COUPON_TYPE') as $key => $obj){
                                        $selected = isset($searchData['Type']) && $searchData['Type'] == $obj->getValue()
                                            ? 'selected="selected"':'';
                                        echo '<option '.$selected.' value="'.$obj->getValue().'">'.\common\enums\Coupon::labels()[$key].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Time1" class="form-control" placeholder="<?= \Yii::t('app', '领取时间');?>"
                                       value="<?=!empty($searchData['Time1'])?$searchData['Time1']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                                -
                                <input type="text" name="Time2" class="form-control" placeholder="<?= \Yii::t('app', '领取时间');?>"
                                       value="<?=!empty($searchData['Time2'])?$searchData['Time2']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                            </div>&nbsp;&nbsp;
                            <div class="form-group form-group-sm">
                                <input type="text" name="UseTime1" class="form-control" placeholder="<?= \Yii::t('app', '使用时间');?>"
                                       value="<?=!empty($searchData['UseTime1'])?$searchData['UseTime1']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                                -
                                <input type="text" name="UseTime2" class="form-control" placeholder="<?= \Yii::t('app', '使用时间');?>"
                                       value="<?=!empty($searchData['UseTime2'])?$searchData['UseTime2']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">查询</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
<!--                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>-->
                            <th>用户ID</th>
                            <th>用户名</th>
                            <th>优惠券ID</th>
                            <th>优惠券名称</th>
                            <th>优惠券类型</th>
                            <th>面额</th>
                            <th>限额</th>
                            <th>适用范围</th>
                            <th>有效期</th>
                            <th>领取时间</th>
                            <th>订单号</th>
                            <th>使用时间</th>
<!--                            <th>操作</th>-->
                        </tr>

                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?=$user['Uid']?></td>
                                <td><?=$user['UserName']?></td>
                                <td><?php echo $user['ID']?></td>
                                <td><?php echo $user['Name']?></td>
                                <td><?php echo \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_TYPE')[$user['Type']]];?></td>
                                <td><?php echo $user['Price']?></td>
                                <td><?php echo $user['MinLimit']?></td>
                                <td><?php if($user['CourseId'] == 0) echo '课程通用';?></td>
                                <td>
                                    <?php
                                        echo date('Y-m-d H:i:s',$user['Expire1']).' ~ '.date('Y-m-d H:i:s',$user['Expire2']);
                                    ?>
                                </td>
                                <td><?=date('Y-m-d H:i:s',$user['Time']);?></td>
                                <td><?=$user['OrderId']?></td>
                                <td><?PHP if(!empty($user['use_time'])) echo date('Y-m-d H:i:s',$user['use_time'])?></td>
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
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">优惠券发放</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>优惠券组ID</th>
                        <th>优惠券标题</th>
                        <th>面额</th>
                        <th>限额</th>
                        <th>适用范围</th>
                        <th>生效方式</th>
                        <th>有效期</th>
                        <th>单账号限制</th>
                    </tr>
                    <tr>
                        <td id="coupon_ID"></td>
                        <td id="coupon_Name"></td>
                        <td id="coupon_Price"></td>
                        <td id="coupon_MinLimit"></td>
                        <td id="coupon_CourseId"></td>
                        <td id="coupon_EffectiveWay"></td>
                        <td id="coupon_EffectiveTime"></td>
                        <td id="coupon_SingleLimit"></td>
                    </tr>
                </table>
                <form class="form-horizontal" action="coupon/allot" id="myForm" role="form">
                    <div class="row">
                        <div class="col-xs-12">
                            <b>剩余可发放数量：</b><span id="coupon_Remainder"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <b>发放账号：</b>
                        </div>
                        <div class="col-xs-5">
                            <textarea name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-xs-4">
                            <div>每行1个，不允许重复，单次最多可添加9999个账号</div>
                            <div>当前已发放：<span id="current_count">0</span></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" onclick="giveOutDo()" class="btn btn-primary">发放</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    $(document).ready(function(){
        $('#content').keyup(
            function(){
                var o = document.getElementById("content").value.replace(/[^\n]/mg,'').length;
                $('#current_count').html(o+1);
            }
        );
    });
</script>