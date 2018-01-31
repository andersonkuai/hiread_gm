<!-- Content Header (Page header) -->
<script language="javascript" type="text/javascript"
        src="/97date/WdatePicker.js"></script>
<section class="content-header">
    <h1>
        区域账号
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">代理商管理</a></li>
        <li class="active">区域账号</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="btn-group btn-group-sm" role="group">
                        <a class="btn btn-primary" href="?r=user/add"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                    <div class="box-tools">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="order/index">
                            <div class="form-group form-group-sm">
                                <input type="text" name="Uid" class="form-control" placeholder="用户ID"
                                       value="<?=!empty($searchData['Uid'])?$searchData['Uid']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="UserName" class="form-control" placeholder="用户名"
                                       value="<?=!empty($searchData['UserName'])?$searchData['UserName']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <input type="text" name="Mobile" class="form-control" placeholder="手机号"
                                       value="<?=!empty($searchData['Mobile'])?$searchData['Mobile']:''?>">
                            </div>
                            <div class="form-group form-group-sm">
                                <select class="form-control" name="PayType" id="">
                                    <option value="" >支付方式</option>
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
                                    <option value="" >订单状态</option>
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
                                    <option value="" >发货状态</option>
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
                                <input type="text" name="activated_time" class="form-control" placeholder="激活时间"
                                       value="<?=!empty($searchData['activated_time'])?$searchData['activated_time']:''?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">确定</button>
                        </form>

                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th style="text-align: center"><input type="checkbox" onclick="UTILITY.CHECK.all(this);"/></th>
                            <th>订单号</th>
                            <th>用户id</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>第三方交易单号</th>
                            <th>订单价格</th>
                            <th>收货地址ID</th>
                            <th>支付方式</th>
                            <th>订单状态</th>
                            <th>发货状态</th>
                            <th>订单支付时间</th>
                            <th>订单生成时间</th>
                            <th>操作</th>
                        </tr>

                        <?php foreach($orders as $val){?>
                            <tr>
                                <td align="center"><input type="checkbox" name="checkids[]" value="<?php echo $val['OrderId'];?>"/></td>
                                <td><?php echo $val['OrderId']?></td>
                                <td><?php echo $val['Uid']?></td>
                                <td><?php echo $val['UserName']?></td>
                                <td><?php echo $val['Mobile']?></td>
                                <td><?php echo $val['Trade']?></td>
                                <td><?php echo $val['Price']?></td>
                                <td><?php echo $val['RecvId']?></td>
                                <td><?php echo $val['PayType']?></td>
                                <td><?php echo $val['Status']?></td>
                                <td><?php echo $val['SendStatus']?></td>
                                <td><?php echo date("Y-m-d", $val['PayTime'])?></td>
                                <td><?php echo date("Y-m-d", $val['Time'])?></td>
                                <td></td>
                            </tr>
                        <?php }?>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=0', '确定禁用？');">禁用</button>
                        <button class="btn btn-default" onclick="UTILITY.CHECK.post('?r=user/status&status=10', '确定解禁？');">解禁</button>
                    </div>
                    <?php echo $pageHtml;?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->