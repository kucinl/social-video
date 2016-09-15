<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/21 0021
 * Time: 0:31
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view('commons/head');
    ?>
<style>
    .tab-pane{
        padding-top: 30px;
    }
</style>
</head>

<body>
<header>
    <?php
    $this->load->view('commons/header_v');
    ?>
</header>

<div class="container">
            <div class="tabbable " id="tabs-691858">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#panel-video" data-toggle="tab">视频</a>
                    </li>
                        <li>
                            <a href="#panel-user" data-toggle="tab">用户</a>
                        </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="panel-video">

                        <div class="col-md-10">
                            <div class="panel-body">
                                <?php if($video_result):?>
                                        <?php foreach($video_result as $v):?>
                                            <div class="col-md-3">
                                                <div>
                                                    <a class="thumbnail" href="<?=base_url()?>video/room/<?=$v['video_order']?>/<?=$account?>" id="img1">
                                                        <img src="<?=base_url()?>upload/video/<?=$v['video_order']?>/poster.jpg" alt="100%x100">
                                                    </a>
                                                    <small><?=$v['name']?></small>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                <?php else:?>
                                    暂时无相关结果
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="panel-user">
                        <div class="panel-body">
                            <?php if($user_result):?>
                                <ul class="media-list">
                                    <?php foreach($user_result as $v):?>
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
                                暂无相关结果
                            <?php endif?>
                        </div>
                    </div>
                </div>

            </div>
    <?php
    $this->load->view('commons/script');
    ?>
    <script language="javascript">
        //初始化选择器
        $("select").select2({dropdownCssClass: ''});
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'flat'
        }
        function re_pwd_check(){
            var new_pwd = $('#new_pwd').val();
            var re_pwd = $('#re_pwd').val();
            if(new_pwd === re_pwd){
                return true;
            }
            else{
                Messenger().post({
                    message: '你的新密码必须与确认密码相同！',
                    type: 'error',
                    showCloseButton: true
                });

                return false;
            }
        }

    </script>
</body>

</html>