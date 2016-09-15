/**
 * Created by kucin on 2016/5/15 0015.
 */
var clipboard = new Clipboard('.btn');
var start_time,
    over_time;
var error = false,
    v_error = false;
// 通过ajax建立和php端处理函数的连接(通过递归调用建立长时间的连接)
var my_video = document.getElementById('player1')
// 创建长时间的连接
$(document).ready(function () {
    start_time = (new Date()).getTime() / 1000;
    connect();
    v_connect();
})

// 关闭窗口时上传历史
$(window).bind('beforeunload', function () {
    upload_history();
})

clipboard.on('success', function(e) {
    $('#copy_button').tooltip({
        title: '复制成功',
        container: 'body',
        trigger: 'manual',
        placement: 'top'
    });
    $('#copy_button').tooltip('show');
});
$('#copy_button').hover(function(){},function () {
    $('#copy_button').tooltip('destroy');
});

$('#history').hover(function () {
    $('#history ul').html('<li><p><img src="<?=base_url()?>dist/img/loading.gif" style="width:12%">数据加载中</p></li>');
    get_history();
})

$("#chat_button").click(function () {
    $.ajax({
        data: {
            'name': '<?=$nick_name?>',
            'content': $('#chat_content').val()
        },
        type: 'post',
        url: '<?=base_url()?>video/insert_chat/<?=$order?>/<?=$room_account?>',
        success: function () {
            $("#chat_content").val("");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    })
})
$("#chat_content").keydown(function (e) {
    if(e.keyCode == 13) {
        $.ajax({
            data: {
                'name': '<?=$nick_name?>',
                'content': $('#chat_content').val()
            },
            type: 'post',
            url: '<?=base_url()?>video/insert_chat/<?=$order?>/<?=$room_account?>',
            success: function () {
                $("#chat_content").val("");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
            }
        })
    }
})

$('#sy_button').click(function () {
    //    alert('!')
    $.ajax({
        data: {
            'name': '<?=$nick_name?>',
            'v_time': my_video.currentTime,
            'm_time': (new Date()).getTime() / 1000,
            'is_play': !(my_video.paused)
        },
        type: 'post',
        url: '<?=base_url()?>video/set_play_progress/<?=$order?>/<?=$room_account?>',
        success: function () {
            //            alert("!")
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
    })

})

// 通过ajax建立和php端处理函数的连接(通过递归调用建立长时间的连接)
function v_connect() {
    // alert('!')
    $.ajax({
        url: '<?=base_url()?>video/get_play_progress/<?=$order?>/<?=$room_account?>',
        type: 'get',
        timeout: 80000,
        success: function (response) {
            //            alert("!")
            var data = JSON.parse(response)
            v_error = false
            if(data.fail == '1'){

            }else {
                var m_name = data['name'],
                    is_play = data['is_play'],
                    v_time = data['v_time'] + (new Date()).getTime() / 1000 - data['m_time']
                if (my_video.readyState == 4) {
                    my_video.currentTime = v_time
                }
                if (is_play == 1) {
                    my_video.play()
                } else {
                    my_video.pause()
                }
                //alert('!')
                var html = '<li class="chat_li chat_danger">' + formatTime(new Date(data["m_time"] * 1000)) + m_name + '将进度同步至' + formatTimeV(v_time) + '</li>'
                var doms = $.parseHTML(html)
                $("#chat_lines ul").append(doms)
            }

        },
        error: function () {
            v_error = true;
        },
        complete: function () {
            if (v_error)
            // 请求有错误时,延迟5s再连接
                setTimeout(function () {
                    v_connect();
                }, 5000);
            else
                v_connect();
        }
    })
}

function connect() {
    $.ajax({
        url: '<?=base_url()?>video/get_new_chat/<?=$order?>/<?=$room_account?>',
        type: 'get',
        timeout: 80000,
        success: function (response) {
            var data = JSON.parse(response);
            error = false;
            if(data.fail == '1'){

            }else {
                for (var i = 0; i < data.length; i++) {
                    var jsonobj = data[i]

                    $("#chat_lines ul").append(
                        '<li class="chat_li"><span class="chat_time">' + formatTime(new Date(jsonobj["time"] * 1000)) + '</span><a href = "#"> ' + jsonobj["name"] + ': </a><span class="char_text">' + jsonobj['content'] + '</span></li>')
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
                    connect();
                }, 5000);
            }
            else {
                console.log('comp')
                connect();
            }
        }
    })
}

function upload_history(){
    var score = $('#score').val();
    over_time = (new Date()).getTime() / 1000;
    $.ajax({
        data: {
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

function get_history() {
    $.ajax({
        type: 'get',
        url: '<?=base_url()?>personer/get_history/5',
        success: function (response) {
            var data = JSON.parse(response);
            $('#history ul').html('');
            for (var i = 0; i < data.length; i++) {
                var jsonobj = data[i]
                $("#history ul").append(
                    '<li > <a href="<?=base_url()?>video/room/'+jsonobj['video_order']+'/<?=$account?>">'
                    + jsonobj['name'] + '</a></li>')
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
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
