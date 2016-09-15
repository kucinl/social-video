<?php
/**
 * Created by PhpStorm.
 * User: kucin
 * Date: 2016/5/20 0020
 * Time: 0:10
 */
?>
<script src="<?= base_url() ?>dist/js/vendor/jquery.min.js"></script>
<script src="<?= base_url() ?>dist/js/vendor/video.js"></script>
<script src="<?= base_url() ?>dist/js/flat-ui.js"></script>
<script src="<?= base_url() ?>dist/js/tooltip.js"></script>
<script src="<?= base_url() ?>dist/js/clipboard.js"></script>
<script src="<?= base_url() ?>dist/js/popover.js"></script>
<script src="<?= base_url() ?>dist/js/star-rating.js"></script>
<script src="<?= base_url() ?>docs/assets/js/application.js"></script>
<script src="<?=base_url()?>dist/js/messenger.min.js"></script>
<script src="<?=base_url()?>dist/js/messenger-theme-flat.js"></script>

<script>
    var clipboard = new Clipboard('.btn');
    var start_time,
        over_time;
    var error = false,
        v_error = false;
    // 通过ajax建立和php端处理函数的连接(通过递归调用建立长时间的连接)
    var my_video = document.getElementById('player1');

    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'flat'
    }
    $(document).ready(function () {
        n_connect();
    })
    $('#history').hover(function () {
        $('#history ul').html('<li><p class="text-center"><i class="fa fa-spinner fa-pulse"></i> 数据加载中</p></li>');
        get_history();
    })
    $('#notice').hover(function () {
        $('#notice ul').html('<li><p class="text-center"><i class="fa fa-spinner fa-pulse"></i> 数据加载中</p></li>');
        get_notice();
    })

    function n_connect() {
        $.ajax({
            url: '<?=base_url()?>notice/get_new_notice',
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
                            case 'invite':
                                Messenger().post({
                                    message: event["title"],
                                    type: 'info',
                                    showCloseButton: true,
                                    actions: {
                                        cancel: {
                                            label: '<i class="fa fa-location-arrow"></i> 接受邀请',
                                            action: function() {
                                                window.location.href=event['content'];
                                            }
                                        }
                                    }
                                });
                                break;
                            case 'add_friend_request':
                                Messenger().post({
                                    message: event["title"],
                                    type: 'info',
                                    showCloseButton: true,
                                    actions: {
                                        cancel: {
                                            label: '<i class="fa fa-location-arrow"></i> 同意添加',
                                            action: function() {

                                            }
                                        }
                                    }
                                });
                                break;
                            case 'add_friend_success':
                                Messenger().post({
                                    message: event["title"],
                                    type: 'success',
                                    showCloseButton: true,
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
                        n_connect();
                    }, 5000);
                }
                else {
                    console.log('comp')
                    n_connect();
                }
            }
        })
    }

    function get_history(){
        $.ajax({
            type: 'get',
            url: '<?=base_url()?>personer/get_history/5',
            success: function (response) {
                var data = JSON.parse(response);
                $('#history ul').html('');
                if(data === null) {
                    $("#history ul").append(
                        '<li ><p class="text-center">您还没有历史记录</p></li>')
                }else {
                    for (var i = 0; i < data.length; i++) {
                        var jsonobj = data[i]
                        $("#history ul").append(
                            '<li > <a href="<?=base_url()?>video/room/' + jsonobj['video_order'] + '/'+jsonobj['room_account']+'">'
                            + jsonobj['name'] + '</a></li>')
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('error')
            }
        })
    }
    function get_notice(){
        $.ajax({
            type: 'get',
            url: '<?=base_url()?>notice/get_notices/5',
            success: function (response) {
                var data = JSON.parse(response);
                $('#notice ul').html('');
                if(data === null) {
                    $("#notice ul").append(
                        '<li ><p class="text-center">您还未收到任何通知</p></li>')
                }else {
                    for (var i = 0; i < data.length; i++) {
                        var jsonobj = data[i]
                        $("#notice ul").append(
                            '<li ><a href='+jsonobj['content']+'>'+ jsonobj['title'] + '</a></li>')
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('error')
            }
        })
    }
    function formatTime(now) {
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        return hour + ":" + minute + ":" + second;
    }

    function formatTimeV(now) {
        var hour = Math.floor(now / 60 / 60);
        var minute = Math.floor((now - hour * 60 * 60) / 60);
        var second = Math.round(now - minute * 60 - hour * 60 * 60);
        return hour + ":" + minute + ":" + second;
    }



</script>
