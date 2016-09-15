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
    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-tabs nav-stacked " id="myNav">
                <li class="active"><a href="<?=base_url()?>personer">个人中心</a></li>
                <li ><a href="<?=base_url()?>personer/friend">我的好友</a></li>
                <li><a href="<?=base_url()?>personer/history">观看历史</a></li>
                <li><a href="<?=base_url()?>personer/notice">消息通知</a></li>
            </ul>
        </div>
        <div class="col-md-10">

            <div class="tabbable " id="tabs-691858">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#panel-info" data-toggle="tab">个人概况</a>
                    </li>
                    <?php if($account == $account_info['account']):?>
                    <li>
                        <a href="#panel-change-info" data-toggle="tab">修改基本信息</a>
                    </li>
                    <li>
                        <a href="#panel-change-avatar" data-toggle="tab">修改头像</a>
                    </li>
                    <li>
                        <a href="#panel-password" data-toggle="tab">修改密码</a>
                    </li>
                    <?php endif;?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="panel-info">

                                <img class="profile-user-img img-responsive img-circle" src="<?=base_url('upload/user/avatar/'.$account_info['i_img'])?>" alt="User profile picture">

                                <h3 class="profile-username text-center"><?=$account_info['nick_name']?></h3>

                                <p class="text-muted text-center"><?=$account_info['career_name']?></p>

                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>居住地</b> <a class="pull-right"><?=$account_info['city_province']?>,<?=$account_info['city_name']?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>年龄</b> <a class="pull-right"><?=$account_info['age']?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>性别</b>
                                        <a class="pull-right">
                                            <?php if($account_info['sex'] == 0):?>男
                                            <?php else:?>女<?php endif;?>
                                        </a>
                                    </li>
                                </ul>

                    </div>
                    <?php if($account == $account_info['account']):?>
                    <div class="tab-pane" id="panel-change-info">
                        <form class="form-horizontal" action="<?=base_url('personer/update_settings')?>" method="post">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">昵称</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="inputName" value="<?=$nick_name?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSex" class="col-sm-2 control-label">性别</label>

                                <div class="col-sm-10">
                                    <select class="form-control select select-primary select-block mbl" id="inputSex" name="sex">
                                            <option value="0" <?php if($sex == 0):?> selected <?php endif;?>>
                                                男
                                            </option>
                                            <option value="1" <?php if($sex == 1):?> selected <?php endif;?>>
                                                女
                                            </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAge" class="col-sm-2 control-label">年龄</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="age" id="inputAge" value="<?=$age?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputLoaction" class="col-sm-2 control-label" >城市</label>
                                <div class="col-sm-10">
                                    <select class="form-control select select-primary select-block mbl" id="inputLocation" name="city" >
                                        <?php foreach ($city_list as $i => $v):?>
                                        <optgroup label="<?=$i?>">
                                            <?php foreach ($v as $vv):?>
                                            <option value="<?=$vv['city_id']?>" <?php if($vv['city_id'] == $city):?> selected <?php endif;?>>
                                                <?=$vv['name']?>
                                            </option>
                                            <?php endforeach;?>
                                        </optgroup>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputCareer" class="col-sm-2 control-label" >职业</label>
                                <div class="col-sm-10">
                                    <select class="form-control select select-primary select-block mbl" id="inputCareer" name="career" >
                                        <?php foreach ($career_list as  $v):?>
                                                    <option value="<?=$v['career_id']?>" <?php if($v['career_id'] == $career):?> selected <?php endif;?>>
                                                        <?=$v['name']?>
                                                    </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">确认修改</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="panel-change-avatar">
                        <form class="form-horizontal" action="<?=base_url('personer/update_avatar')?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputFile" class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-10">
                                    <input  class="none" id="avatar" name="avatar_file" type="file" class="file-loading" >

                                    <!-- include other inputs if needed and include a form submit (save) button -->

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">上传并修改</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="panel-password">
                        <form class="form-horizontal" action="<?=base_url('personer/update_pwd')?>" method="post" onsubmit="return re_pwd_check();">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="old_pwd">原密码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="old_pwd" name="old_pwd" placeholder="Password" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="new_pwd">新密码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="new_pwd" name="new_pwd" placeholder="Password" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="re_pwd">确认密码</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="re_pwd" name="re_pwd" placeholder="Password" type="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">确认修改</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif;?>
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