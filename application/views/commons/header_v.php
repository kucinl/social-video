<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/12 0012
 * Time: 11:12
 */
?>

<nav class="navbar navbar-inverse navbar-lg " role="navigation">
    <div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
            <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="<?=base_url()?>video">Kucin</a>
    </div>
    <div class="collapse navbar-collapse " id="navbar-collapse-01">

        <div class="nav navbar-nav center-block ">
            <form class="navbar-form  " action="<?=base_url('search')?>" role="search" type="post">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" id="word" name="word" type="search" placeholder="搜索视频或用户">
                                    <span class="input-group-btn">
                      <button type="submit" class="btn"><span class="fui-search"></span></button>
                                    </span>
                    </div>
                </div>
            </form>
        </div>




        <ul class="nav navbar-nav navbar-right">
            <li class="hovermenu hovermenu-right" id="notice">
                <a href="#fakelink"><span class="fa fa-bell-o"></span> 通知</a>
                <span class="navbar-unread"></span>
                <ul>

                </ul>
            </li>

            <li class="hovermenu hovermenu-right" id="history">
                <a href="#fakelink" ><span class="fa fa-history"></span> 历史</a>
                <ul>
                </ul>
            </li>

            <li>
                <!-- User Account: style can be found in dropdown.less -->
            <li class="hovermenu hovermenu-right user user-menu" id="myDropdown">
                <a href="#" >
                    <img src="<?=base_url('upload/user/avatar/'.$i_img)?>" class="user-image" alt="User Image">
                                <span class="hidden-xs">
                                        <?=$nick_name?></span>
                </a>
                <ul >
                    <li><a href="<?=base_url()?>personer">个人中心</a></li>
                    <li><a href="<?=base_url()?>personer/friend">我的好友</a></li>
                    <li><a href="<?=base_url()?>personer/history">观看历史</a></li>
                    <li><a href="<?=base_url()?>personer/notice">消息通知</a></li>
                    <li><a href="<?=base_url()?>login/logout">登出</a></li>
                </ul>
    </div>
    <!-- /.navbar-collapse -->
        </div>
</nav>

<!-- /navbar -->
