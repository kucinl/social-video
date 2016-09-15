<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登录-kucin</title>
    <!-- Loading Bootstrap -->
    <link href="<?=base_url()?>dist/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Loading Flat UI -->
    <link href="<?=base_url()?>dist/css/flat-ui.css" rel="stylesheet">
    <link href="<?=base_url()?>dist/css/flat-ui-pro.css" rel="stylesheet">
    <link href="<?=base_url()?>docs/assets/css/demo.css" rel="stylesheet">

</head>

<body>
    <div class="section">
        <div class="container">
            <div></div>
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">
                    <b>登录——kucin</b>
                </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form id="l_form" action="<?=base_url()?>login" method="post" role="form" class="form-horizontal">
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="account">用户名</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account" name="account" placeholder="Account" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="pwd">密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="pwd" name="pwd" placeholder="Password" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" ></label>
                            <div class="col-sm-10">
                                <button id="my_submit" name="btn" type="button" class="btn btn-primary btn-block">登录</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" ></label>
                            <div class="col-sm-10">
                            <label class="checkbox" for="checkbox3">
                                <input type="checkbox" data-toggle="checkbox" value="" id="checkbox3" required="" class="custom-checkbox" checked>
                                记住账号
                                <a class="pull-right" href="<?=base_url()?>register" >
                                    还没有账号？
                                </a>
                            </label>
                                </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url()?>dist/js/vendor/jquery.min.js"></script>
    <script src="<?=base_url()?>dist/js/flat-ui.js"></script>
    <script src="<?=base_url()?>dist/js/tooltip.js"></script>
    <script src="<?=base_url()?>docs/assets/js/application.js"></script>

    <script>
        function trim(str) { //删除左右两端的空格
            return str.replace(/(^\s*)|(\s*$)/g, "");
        }

        $('#account').keyup(function () {
            $('#account').tooltip('destroy');
            $('#pwd').tooltip('destroy');
        });
        $('#pwd').keyup(function () {
            $('#pwd').tooltip('destroy');
        });
        $('#pwd').focus(function () {
            if ($('#account').val() == '') {
                $('#account').tooltip({
                    title: '请输入用户名',
                    container: 'body',
                    trigger: 'manual',
                    placement: 'right'
                });
                $('#account').tooltip('show');
            }
        });
        $('#my_submit').click(function () {
            if ($('#account').val() == '') {
                $('#account').tooltip({
                    title: '请输入用户名',
                    container: 'body',
                    trigger: 'manual',
                    placement: 'right'
                });
                $('#account').tooltip('show');
                $("#account").focus();
            } else if ($('#pwd').val() == '') {
                $('#pwd').tooltip({
                    title: '密码不能为空',
                    container: 'body',
                    trigger: 'manual',
                    placement: 'right'
                });
                $('#pwd').tooltip('show');
                $("#pwd").focus();
            } else {
                $("#l_form").submit()
            }
        });
    </script>
</body>

</html>