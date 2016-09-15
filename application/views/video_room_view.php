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

<section>
    <div class="container">


        <div class="row ">

            <div class="col-xs-8">
                <video class="video-js" preload="auto" id="player1"
                       poster="<?=base_url()?>upload/video/<?=$video['video_order']?>/poster.jpg" data-setup="{}">
                    <source src="<?=$video['address']?>" type="video/mp4">
                </video>
                <div class="row ">

                    <div class="col-md-8">
                        <input id="score" class="rating" starCaptions=4 data-show-clear="false"
                               data-show-caption="false" value="3" data-size="md">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-inverse pull-right" id="copy_button" style="margin-top: 40px"
                                data-clipboard-text="<?=base_url()?>video/room/<?=$video['video_order']?>/<?=$room_account?>" type="button">
                            <i class="fa fa-link"></i> 复制邀请链接
                        </button>
                    </div>
                    <div class="col-md-2">
                        <input id="sy_check"type="checkbox" name="my-checkbox" checked>
                        <button id="sy_button" class="btn btn-inverse pull-right" type="button"><span
                                class="fa fa-tv"></span> 同步
                        </button>
                    </div>
                </div>
            </div>

            <!-- /video -->

            <div class="col-xs-4">

                <div class="chat_cont" >
                    <div id="show-test" style="position: relative">
                        <a class="btn btn-default btn-block" role="button" >
                            邀请站内好友共同观看
                        </a>
                        <div class="ab-hide" style="background-color:white">
                            <?php if($friend_list):?>
                                <ul class="media-list">
                                    <?php foreach($friend_list as $v):?>
                                        <li class="media">
                                            <a class="" href="<?=base_url('personer/information/'.$v['account']);?>">
                                                <img class="user-image-med" src="<?=base_url('upload/user/avatar/'.$i_img)?>" alt="<?=$v['name'];?>">
                                            </a>

                                            <small class="">
                                                <span><a href="<?=base_url('personer/information/'.$v['account']);?>"><?=$v['name'];?></a></span>
                                                <button class="btn btn-inverse pull-right invite_btn"  oppo-account="<?=$v['account']?>">
                                                    <span class="fa fa-paper-plane-o"></span>
                                                </button>
                                            </small>

                                        </li>
                                    <?php endforeach;?>
                                </ul>

                            <?php else:?>
                                你还没有好友
                            <?php endif?>
                        </div>
                    </div>
                    <div class="chat_lines" id="chat_lines">
                        <ul>
                        </ul>
                    </div>
                    <div class="chat_speak">
                        <form class="form-group" id="chat_form" onkeydown="if(event.keyCode==13)return false;">
                            <div class="input-group">
                                <input class="form-control" id="chat_content" name="content" type="text" rows="2">
                                     <span class="input-group-btn">
                                        <button id="chat_button" class="btn btn-default" type="button">发送
                                        </button>
                                         </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col-xs-4 -->
        </div>
    </div>
</section>

<footer>

</footer>

<?php
$this->load->view('commons/script');
?>
<script>
    $("[name='my-checkbox']").bootstrapSwitch();
    // 创建长时间的连接
    $(document).ready(function () {
        start_time = (new Date()).getTime() / 1000;
        // connect();
        // v_connect();
        get_today_chat();
        e_connect();
        come_in();
    })
    // 关闭窗口时上传历史
    $(window).bind('beforeunload', function () {
        upload_history();
        leave_out();
    })
    $('#show-test').hover(function (){
            $('.ab-hide').show();
        },
        function (){
            $('.ab-hide').hide();
        })
    clipboard.on('success', function(e) {
        $('#copy_button').tooltip({
            title: '复制成功',
            container: 'body',
            trigger: 'manual',
            placement: 'left'
        });
        $('#copy_button').tooltip('show');
    });
    $('#copy_button').hover(function(){},function () {
        $('#copy_button').tooltip('destroy');
    });
    $('.invite_btn').click(function () {
        var to_account = $(this).attr("oppo-account"),
            from_account = '<?=$account?>',
            from_name = '<?=$nick_name?>',
            video_order = <?=$video['video_order']?>,
            video_name = '<?=$video['name']?>';
        send_invite_notice(from_account,to_account,from_name,video_order,video_name);
        $(this).tooltip({
            title: '已发送邀请链接给'+to_account,
            container: 'body',
            // trigger: 'manual',
            placement: 'right'
        });
        $(this).tooltip('show');
    });

    $("#chat_button").click(function () {
        send_chat();
    })
    $("#chat_content").keydown(function (e) {
        if(e.keyCode == 13) {
            send_chat();
        }
    })

    $('#sy_button').click(function () {
        change_progress();
    })
    /*$('#sy_check').click(function(){
        if($('#sy_check').attr('checked') == true){
            $('#sy_check').attr('checked',false)
            alert('11')
        }
        else{
            $('#sy_check').attr('checked',true)
            alert('22')
        }
    })*/
    function e_connect() {
        $.ajax({
            url: '<?=base_url()?>video/get_new_event/<?=$order?>/<?=$room_account?>',
            type: 'get',
            timeout: 80000,
            success: function (response) {
                var data = JSON.parse(response);
                error = false;
                if(data['fail'] == '1'){
                    console.log('get event fail')
                }else {
                    for (var i = 0; i < data.length; i++) {
                        var event = data[i]
                        switch(event.type){
                            case 'chat':
                                $("#chat_lines ul").append(
                                    '<li class="chat_li"><span class="chat_time">' + formatTime(new Date(event["time"] * 1000))
                                    + '</span><a href = "#"> ' + event["name"] + ': </a><span class="char_text">'
                                    + event['content'] + '</span></li>');
                                break;
                            case 'video_progress':
                                var m_name = event['name'],
                                    is_play = event['is_play'],
                                    v_time = event['v_time'];

                                    if (my_video.readyState == 4) {
                                        my_video.currentTime = v_time
                                    }
                                    if (is_play == 1) {
                                        my_video.play()
                                    } else {
                                        my_video.pause()
                                    }
                                    Messenger().post({
                                        message: m_name + '将进度同步至' + formatTimeV(v_time),
                                        type: 'success',
                                        showCloseButton: true
                                    });

                               /*     Messenger().post({
                                        message: '您拒绝了'+m_name + '的同步' ,
                                        type: 'error',
                                        showCloseButton: true
                                    });*/

                                /*var html = '<li class="chat_li chat_danger">' + formatTime(new Date(event["time"] * 1000))
                                 + m_name + '将进度同步至' + formatTimeV(v_time) + '</li>';
                                 var doms = $.parseHTML(html);
                                 $("#chat_lines ul").append(doms);*/
                                break;
                            case 'come_in':
                                Messenger().post({
                                    message: event["name"] + '进入本房间',
                                    type: 'info',
                                    showCloseButton: true
                                });
                                /* $("#chat_lines ul").append(
                                 '<li class="chat_li"><span class="chat_time">' + formatTime(new Date(event["time"] * 1000))
                                 + '</span><a href = "#"> ' + event["name"] + '</a><span class="char_text">进入了本房间</span></li>');*/
                                break;
                            case 'leave_out':
                                Messenger().post({
                                    message: event["name"] + '离开本房间',
                                    type: 'info',
                                    showCloseButton: true
                                });
                                break;
                            default:
                                console.log('no such event');
                        }

                    }
                }
            },
            error: function () {
                error = true;
                console.log('connect error')
            },
            complete: function () {
                if (error) {
                    console.log('error comp')
                    // 请求有错误时,延迟5s再连接
                    setTimeout(function () {
                        e_connect();
                    }, 5000);
                }
                else {
                    console.log('comp')
                    e_connect();
                }
            }
        })
    }

    function send_chat() {
        $.ajax({
            data: {
                'type': 'chat',
                'name': '<?=$nick_name?>',
                'content': $('#chat_content').val(),
                'v_time': 0,
                'is_play': 0
            },
            type: 'post',
            url: '<?=base_url()?>video/set_new_event/<?=$order?>/<?=$room_account?>',
            success: function () {
                $("#chat_content").val("");
            },
            error: function () {
                console.log('error');
            }
        })
    }
    function get_today_chat(){
        $.ajax({
            type: 'get',
            url: '<?=base_url()?>video/get_today_chat/<?=$order?>/<?=$room_account?>',
            success: function (response) {
                var data = JSON.parse(response);
                for (var i = 0; i < data.length; i++) {
                    var event = data[i];
                    $("#chat_lines ul").append(
                        '<li class="chat_li"><span class="chat_time">' + formatTime(new Date(event["time"] * 1000))
                        + '</span><a href = "#"> ' + event["name"] + ': </a><span class="char_text">'
                        + event['content'] + '</span></li>');
                }
            },
            error: function () {
                console.log('error');
            }
        })
    }
    function change_progress(){
        $.ajax({
            data: {
                'type': 'video_progress',
                'name': '<?=$nick_name?>',
                'content': '',
                'v_time': my_video.currentTime,
                'is_play': !(my_video.paused)
            },
            type: 'post',
            url: '<?=base_url()?>video/set_new_event/<?=$order?>/<?=$room_account?>',
            success: function () {
                //            alert("!")
            },
            error: function () {
                console.log('error');
            }
        })
    }
    function come_in(){
        $.ajax({
            data: {
                'type': 'come_in',
                'name': '<?=$nick_name?>',
                'content': '',
                'v_time': 0,
                'is_play': 0
            },
            type: 'post',
            url: '<?=base_url()?>video/set_new_event/<?=$order?>/<?=$room_account?>',
            success: function () {
                //            alert("!")
            },
            error: function () {
                console.log('error');
            }
        })
    }
    function leave_out(){
        $.ajax({
            data: {
                'type': 'leave_out',
                'name': '<?=$nick_name?>',
                'content': '',
                'v_time': 0,
                'is_play': 0
            },
            type: 'post',
            url: '<?=base_url()?>video/set_new_event/<?=$order?>/<?=$room_account?>',
            success: function () {
                //            alert("!")
            },
            error: function () {
                console.log('error');
            }
        })
    }
    function upload_history(){
        var score = $('#score').val();
        over_time = (new Date()).getTime() / 1000;
        $.ajax({
            data: {
                'room_account': '<?=$room_account?>',
                'score': score,
                'time': over_time - start_time
            },
            type: 'post',
            url: '<?=base_url()?>personer/insert_history/<?=$order?>',
            success: function () {
                console.log("upload success")
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("upload error")
            }
        })
    }
    function send_invite_notice(from_account,to_account,from_name,video_order,video_name) {
        $.ajax({
            data: {
                'from_account': from_account,
                'to_account': to_account,
                'from_name': from_name,
                'video_order': video_order,
                'video_name': video_name
            },
            type: 'post',
            url: '<?=base_url()?>notice/sent_invite_notice',
            success: function () {
                console.log('success');
            },
            error: function () {
                console.log('error');
            }
        })
    }
</script>
</body>

</html>
