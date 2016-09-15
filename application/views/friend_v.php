<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/15 0015
 * Time: 18:29
 */
?>
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
                <li class="active"><a href="<?=base_url()?>personer/friend">我的好友</a></li>
                <li><a href="<?=base_url()?>personer/history">观看历史</a></li>
                <li><a href="<?=base_url()?>personer/notice">消息通知</a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="panel-body">
                <?php if($friend_list):?>
                    <ul class="media-list">
                        <?php foreach($friend_list as $v):?>
                            <li class="media">
                                <a class="" href="<?=base_url('personer/information/'.$v['account']);?>"><img class="user-image-med" src="<?=base_url('upload/user/avatar/'.$v['avatar']);?>" alt="<?=$v['name'];?>"></a>

                                <small class="">

                                    <span><a href="<?=base_url('personer/information/'.$v['account']);?>"><?=$v['name'];?></a></span>
                                    <a class="btn btn-default" href="<?=base_url('personer/delete_friend/'.$v['account']);?>"><span class="fa fa-close"></span></a>
                                </small>

                            </li>
                        <?php endforeach;?>
                    </ul>

                <?php else:?>
                    你还没有好友
                <?php endif?>
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
