<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= \Yii::t('app', '生成毕业证书');?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="?r=admin/index"><i class="fa fa-dashboard"></i> <?= \Yii::t('app','主页  ')?></a></li>
        <li><a href="#"><?= \Yii::t('app','功能管理')?></a></li>
        <li class="active"><?= \Yii::t('app', '生成毕业证书');?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <div class="col-xs-6">
                        <?php 
                            if(!empty($_GET['name'])){
                                $param = '&name='.$_GET['name'];
                                $param .= '&course='.$_GET['course'];
                                $param .= '&in_books='.$_GET['in_books'];
                                $param .= '&ex_books='.$_GET['ex_books'];
                                $param .= '&read='.$_GET['read'];
                                $param .= '&read_aloud='.$_GET['read_aloud'];
                                $param .= '&words='.$_GET['words'];
                                $param .= '&min='.$_GET['min'];

                                $fileName = $_GET['name'].'_'.$_GET['course'].'_'.$_GET['in_books'].'_'.$_GET['ex_books'].'_'.$_GET['read'].'_'.$_GET['read_aloud'].'_'.$_GET['words'].'_'.$_GET['min'].'_'.$_GET['award'].'_'.$_GET['en_award'].'_'.$_GET['date'].'.jpeg';

                                echo '<img width="400" src="/static/download/'.$fileName.'">';
                            }
                         ?>
                    </div>
                    <div class="col-xs-6">
                        <form action="" method="get" class="form-inline">
                            <input type="hidden" name="r" value="img/create">
                            <table class="table">
                                <tr>
                                    <td><input type="text" name="name" class="form-control" placeholder="英文名"
                                           value="<?=!empty($_GET['name'])?$_GET['name']:''?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="course" class="form-control" placeholder="课程"
                                           value="<?=!empty($_GET['course'])?$_GET['course']:''?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="award" class="form-control" placeholder="奖项"
                                           value="<?=!empty($_GET['award'])?$_GET['award']:'英文阅读小达人奖'?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="en_award" class="form-control" placeholder="奖项（英文）"
                                           value="<?=!empty($_GET['en_award'])?$_GET['en_award']:'STAR READER Award'?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="date" class="form-control" placeholder="日期"
                                           value="<?=!empty($_GET['date'])?$_GET['date']:''?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>精读<input type="text" name="in_books" class="form-control" 
                                           value="<?=!empty($_GET['in_books'])?$_GET['in_books']:0?>" />本书
                                    </td>
                                </tr>
                                <tr>
                                    <td>泛读<input type="text" name="ex_books" class="form-control" 
                                           value="<?=!empty($_GET['ex_books'])?$_GET['ex_books']:0?>" />本书
                                    </td>
                                </tr>
                                <tr>
                                    <td>累计阅读<input type="text" name="read" class="form-control" 
                                           value="<?=!empty($_GET['read'])?$_GET['read']:0?>" />字
                                    </td>
                                </tr>
                                 <tr>
                                    <td>坚持朗读<input type="text" name="read_aloud" class="form-control" 
                                           value="<?=!empty($_GET['read_aloud'])?$_GET['read_aloud']:0?>" />天
                                    </td>
                                </tr>
                                 <tr>
                                    <td>掌握词组<input type="text" name="words" class="form-control" 
                                           value="<?=!empty($_GET['words'])?$_GET['words']:0?>" />个
                                    </td>
                                </tr>
                                 <tr>
                                    <td>外教互动<input type="text" name="min" class="form-control" 
                                           value="<?=!empty($_GET['min'])?$_GET['min']:0?>" />分钟
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-primary btn-sm">生成</button>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <hr>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

<script>
    function test() {
        console.log(123);
        $.get( 'index.php?r=img/download-new',[], function(data){
            console.log(data);
            
        }, 'json');
    }
</script>