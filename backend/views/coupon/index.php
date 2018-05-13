<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '优惠券组列表');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','功能管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '优惠券组列表');?></li>
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
                                <input type="text" name="ID" class="form-control" placeholder="优惠券ID"
                                       value="<?=!empty($searchData['ID'])?$searchData['ID']:''?>">
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
                                <select class="form-control" name="state" id="">
                                    <option value="">优惠券状态</option>
                                    <?php
                                    foreach (\common\enums\Coupon::pfvalues('COUPON_STATE') as $key => $obj){
                                        $selected = isset($searchData['state']) && $searchData['state'] == $obj->getValue()
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
                            <th>优惠券ID</th>
                            <th>优惠券名称</th>
                            <th>类型</th>
                            <th>面额</th>
                            <th>限额</th>
                            <th>适用范围</th>
                            <th>生效方式</th>
                            <th>有效期</th>
                            <th>单账号限制</th>
                            <th>申请券数</th>
                            <th>已发券数</th>
                            <th>已使用</th>
                            <th>优惠券状态</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach($users as $user){?>
                            <tr>
                                <td><?php echo $user['ID']?></td>
                                <td><?php echo $user['Name']?></td>
                                <td><?php echo \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_TYPE')[$user['Type']]];?></td>
                                <td><?php echo $user['Price']?></td>
                                <td><?php echo $user['MinLimit']?></td>
                                <td><?php if($user['CourseId'] == 0) echo '课程通用';?></td>
                                <td><?php echo \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_EFFECTIVE_WAY')[$user['EffectiveWay']]];?></td>
                                <td>
                                    <?php
                                        if($user['EffectiveWay'] == 1){
                                            echo date('Y-m-d H:i:s',$user['EffectiveTime1']).' ~ '.date('Y-m-d H:i:s',$user['EffectiveTime2']);
                                        }else{
                                            echo $user['EffectiveDay'].'天';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $user['SingleLimit'];?></td>
                                <td><?php echo $user['Count'];?></td>
                                <td><?php echo $user['AlCount'];?></td>
                                <td><?php echo 0;?></td>
                                <td>
                                    <?php switch ($user['state']){
                                        case 2:
                                            $style = 'color:green;font-weight:bold;';break;
                                        case 3:
                                            $style = 'color:red';break;
                                        default:
                                            $style = 'color:black';break;
                                    }?>
                                    <span style="<?php echo $style?>">
                                        <?php echo \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_STATE')[$user['state']]];?>
                                    </span>
<!--                                    --><?php //echo $user['state'];?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <?php if($user['state'] == 1){?>
                                            <a class="" style="color: #00aa00" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=coupon/operation&action=2&id=<?php echo $user['ID']?>');">
                                                <i class="fa fa-check-square-o"></i>生效
                                            </a>&nbsp;&nbsp;
                                            <a href="?r=coupon/edit&id=<?php echo $user['ID']?>" target="_Blank"><i class="fa fa-edit"></i>修改</a>&nbsp;&nbsp;
                                            <a class="" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=coupon/del&id=<?php echo $user['ID']?>');"><i class="fa fa-minus-square"></i> 删除</a>&nbsp;&nbsp;
                                            <a href="?r=coupon/list&ID=<?php echo $user['ID']?>" target="_Blank"><i class="fa fa-edit"></i>列表</a>
                                        <?php }elseif($user['state'] == 2){?>
                                            <a class="" href="##" onclick="giveOut('<?=$user['ID']?>')" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-send"></i>发放
                                            </a>
                                            <a class="" style="color: red" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=coupon/operation&action=3&id=<?php echo $user['ID']?>');">
                                                <i class="fa fa-ban"></i>失效
                                            </a>
                                            <a href="?r=coupon/list&ID=<?php echo $user['ID']?>" target="_Blank"><i class="fa fa-edit"></i>列表</a>
                                        <?php }elseif($user['state'] == 3){?>
                                            <a class="" style="color: #00aa00" href="javascript:void(0)" onclick="UTILITY.OPERATE.get('?r=coupon/operation&action=2&id=<?php echo $user['ID']?>');">
                                                <i class="fa fa-check-square-o"></i>生效
                                            <a href="?r=coupon/list&ID=<?php echo $user['ID']?>" target="_Blank"><i class="fa fa-edit"></i>列表</a>
                                        <?php } ?>
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
    function giveOut(id) {
        if(id == ''){
            return;
        }
        //查询优惠券信息
        var postData = {"id":id};
        $.post( 'index.php?r=coupon/query-coupon', postData, function(data){
            console.log(data);
            if( data.code == 1 ){
                $('#coupon_ID').html(data.data.ID);
                $('#coupon_Name').html(data.data.Name);
                $('#coupon_Price').html(data.data.Price);
                $('#coupon_MinLimit').html(data.data.MinLimit);
                $('#coupon_CourseId').html(data.data.CourseId);
                $('#coupon_EffectiveWay').html(data.data.EffectiveWay);
                $('#coupon_EffectiveTime').html(data.data.EffectiveTime);
                $('#coupon_SingleLimit').html(data.data.SingleLimit);
                $('#coupon_Remainder').html(data.data.Count - data.data.AlCount);
            }else{
                alert(data.msg);
            }
        }, 'json');
    }
    function giveOutDo() {
        var id = $('#coupon_ID').html();
        var content = $('#content').val();
        var re = /([\n\r])+/g;
        content=content.replace(re,'-hiread-');
        var postData = {'id':id,'content':content};
        $.post( 'index.php?r=coupon/give-out',postData, function(data){
            console.log(data);
            if( data.code == 1 ){
                alert('发放成功！');
                giveOut(id);
            }else{
                alert(data.msg);
                giveOut(id);
            }
        }, 'json');
    }
</script>