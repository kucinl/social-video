<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view('commons/head');
    ?>
</head>

<body>
<header>
    <?php
    $this->load->view('commons/header_v');
    ?>
</header>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-tabs nav-stacked " id="myNav">
                <li ><a href="<?=base_url()?>personer">个人中心</a></li>
                <li ><a href="<?=base_url()?>personer/friend">我的好友</a></li>
                <li><a href="<?=base_url()?>personer/history">观看历史</a></li>
                <li class="active"><a href="<?=base_url()?>personer/notice">消息通知</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="">
                <table class="table">
                    <thead>
                        <tr class="info">
                            <td>
                                <input class="" id="checkall_btn" type="checkbox">
                            </td>
                            <td><span class="glyphicon glyphicon-envelope"></span></td>
                            <td>主题</td>
                            <td>时间</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($notice_list):?>
                    <?php foreach($notice_list as $v):?>
                            <tr>
                                <td>
                                    <input class="" id="checkall_btn" type="checkbox">
                                </td>
                                <td><span class="glyphicon glyphicon-envelope"></span></td>
                                <td><?=$v['title']?></td>
                                <td ><?=friendly_date($v['time'])?></td>
                            </tr>
                        <?php endforeach;?>

                    <?php else:?>
                        暂时没有消息记录
                    <?php endif?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('commons/script');
?>
<script language="javascript">
    //初始化选择器
    $("select").select2({dropdownCssClass: 'dropdown-inverse'});
</script>
</body>

</html>