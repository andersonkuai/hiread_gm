<?php $controllerActionId = Yii::$app->controller->caid;?>
<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">HEADER</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="<?php echo $controllerActionId == 'admin.index'?'active':''?>"><a data-pjax href="/index.php?r=admin/index"><i class="fa fa-dashboard"></i> <span>控制面板</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-lock"></i> <span>权限管理</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo $controllerActionId == 'auth.user'?'active':''?>"><a data-pjax href="/index.php?r=auth/user"><i class="fa fa-circle-o"></i>管理员列表</a></li>
            <li class="<?php echo $controllerActionId == 'auth.perm'?'active':''?>"><a data-pjax href="/index.php?r=auth/perm"><i class="fa fa-circle-o"></i>权限列表</a></li>
            <li class="<?php echo $controllerActionId == 'auth.role'?'active':''?>"><a data-pjax href="/index.php?r=auth/role"><i class="fa fa-circle-o"></i>角色列表</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-user"></i> <span>用户管理</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo $controllerActionId == 'user.index'?'active':''?>"><a data-pjax href="/index.php?r=user/index"><i class="fa fa-circle-o"></i>用户列表</a></li>
        </ul>
    </li>

</ul>
<!-- /.sidebar-menu -->
<script type="text/javascript">
    $("li.active").parents('li').addClass('active');
</script>