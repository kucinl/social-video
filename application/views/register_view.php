<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>注册-kucin</title>
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
                    <b>注册——kucin</b>
                </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form class="form-horizontal" action="<?=base_url()?>register" method="post" role="form">
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="account">账号</label>
                            <div class="col-sm-10">
                                <input class=" form-control" name="account" id="account" value="<?=set_value('account')?>" placeholder="Account" type="text">
                            </div>
                        </div>
                        <div class="form-group " id="name_area">
                            <label class="col-sm-2 control-label" for="name">昵称</label>
                            <div class="col-sm-10">
                                <input class=" form-control"  name="name"  value="<?=set_value('name')?>" placeholder="Name" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="pwd">密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="pwd" name="pwd" value="<?=set_value('pwd')?>" placeholder="Password" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" ></label>
                            <div class="col-sm-10">
                                <input id="submit" type="submit" value="注册" class="btn btn-primary btn-block">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" ></label>
                            <div class="col-sm-10">

                                    <a class="pull-right" href="<?=base_url()?>login" >
                                        已有账号？
                                    </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="cover">
        <div class="cover-image"></div>
    </div>
    <script src="<?=base_url()?>dist/js/vendor/jquery.min.js"></script>
    <script src="<?=base_url()?>dist/js/flat-ui.js"></script>
    <script src="<?=base_url()?>dist/js/tooltip.js"></script>
    <script src="<?=base_url()?>docs/assets/js/application.js"></script>

    <script>
        $(document).ready(function(){
            $('#name_area').hide();
        });
        $('#account').keyup(function(){
            $('#name_area').fadeIn() ;
        });
    </script>
</body>

</html>