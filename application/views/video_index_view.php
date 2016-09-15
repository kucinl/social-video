<!DOCTYPE html>
<html lang="">

<head>
    <?php
    $this->load->view('commons/head');
    ?>


    <style>
        article {
            margin: 30px 0px;
        }

        aside {
            margin: 30px 0px;
        }

        .myDivider {
            height: 1px;
            margin: 10px 0;
            overflow: hidden;
            background-color: #00ffff;
        }

        .link-gray-normal {
            color: #999;
            font-weight: 400;
        }

        .link-gray-normal:visited {
            color: #999;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
<?php
$this->load->view('commons/header_v');
?>
        <div class="container">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <a href="<?=base_url()?>video/room/3/<?=$account?>"><img src="<?=base_url()?>img/thumbnail/3.png" alt="..."></a>
                    <div class="carousel-caption">
                        移动迷宫Ⅱ
                    </div>
                </div>
                <div class="item">
                    <a href="<?=base_url()?>video/room/3/<?=$account?>"><img src="<?=base_url()?>img/thumbnail/3.png" alt="..."></a>
                    <div class="carousel-caption">
                        移动迷宫Ⅱ
                    </div>
                </div>
                <div class="item">
                    <a href="<?=base_url()?>video/room/3/<?=$account?>"><img src="<?=base_url()?>img/thumbnail/3.png" alt="..."></a>
                    <div class="carousel-caption">
                        移动迷宫Ⅱ
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
            </div>
    </header>
    <div class="container">
        <header class="primary">

        </header>
        <!-- Content goes in here -->
        <div class="row">
            <article class="col-md-9">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                <b class="h4">劲爆影视</b>
                <a class="pull-right link-gray-normal" href="#">
                    <li class=" glyphicon glyphicon-cog" aria-hidden="true"></li>设置
                </a>
                <hr class="myDivider">
                <div class="row">
                    <?php
                    foreach ($video_list as $v):
                    ?>
                    <div class="col-md-3">
                        <div>
                            <a class="thumbnail" href="<?=base_url()?>video/room/<?=$v['video_order']?>/<?=$account?>" id="img1">
                                <img src="<?=base_url()?>upload/video/<?=$v['video_order']?>/poster.jpg" alt="100%x100">
                            </a>
                            <small><?=$v['name']?></small>
                        </div>
                    </div>
                        <?php
                    endforeach;
                    ?>
                </div>

                <!-- Content ends -->
            </article>
            <aside class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading "> 好友推荐
<div class="pull-right">
                         </div>
                       </div>
                    <div class="panel-body">
                        <?php if($recommend_list):?>
                            <ul class="media-list">
                                <?php foreach($recommend_list as $r):?>
                                    <li class="media">
                                        <a class="" href="<?=base_url('personer/information/'.$r['account']);?>"><img class="user-image-med" src="<?=base_url('upload/user/avatar/'.$r['avatar']);?>" alt="<?=$r['name'];?>"></a>

                                            <small class="">

                                                <span><a href="<?=base_url('personer/information/'.$r['account']);?>"><?=$r['name'];?></a></span>
<a class="btn btn-default" href="<?=base_url('personer/add_friend/'.$r['account']);?>"><span class="fa fa-user-plus"></span></a>
                                            </small>

                                    </li>
                                <?php endforeach;?>
                            </ul>

                        <?php else:?>
                            暂时没有可推荐的好友
                        <?php endif?>
                    </div>
                </div>

            </aside>
        </div>

    </div>
    <?php
    $this->load->view('commons/script');
    ?>
    <script >
        //  $('.carousel').carousel()
        $("[name='my-checkbox']").bootstrapSwitch();


    </script>
</body>

</html>
