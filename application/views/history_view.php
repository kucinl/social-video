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
                <li class="active"><a href="<?=base_url()?>personer/history">观看历史</a></li>
                <li><a href="<?=base_url()?>personer/notice">消息通知</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div >
                <table class="table">
                    <thead>
                        <tr class="info">
                            <td>
                                <input class="" id="checkall_btn" type="checkbox">
                            </td>
                            <td><span class="glyphicon glyphicon-film"></span></td>
                            <td>观看历史</td>
                            <td>时间</td>
                            <td>观看时长</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($history_list):?>
                            <?php foreach($history_list as $v):?>
                            <tr>
                                <td>
                                    <input class="" id="checkall_btn" type="checkbox">
                                </td>
                                <td><span class="glyphicon glyphicon-film"></span></td>
                                <td><a href="<?=base_url()?>video/room/<?=$v['video_order']?>/<?=$account?>"><?=$v['name']?></a></td>
                                <td ><?=friendly_date($v['last_time'])?></td>
                                <td><?=friendly_time($v['watch_time'])?></td>
                            </tr>
                            <?php endforeach;?>

                    <?php else:?>
                        暂时没有历史记录
                    <?php endif?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>dist/js/vendor/jquery.min.js"></script>
<script src="<?=base_url()?>dist/js/flat-ui.js"></script>
<script src="<?=base_url()?>docs/assets/js/application.js"></script>
<script language="javascript">
    <?php
    $this->load->view('commons/script');
    ?>
</script>
</body>

</html>