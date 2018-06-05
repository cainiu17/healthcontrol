$(function () {
    $(document).on('keyup','#Ccode',function () {
        var ucode = $('#Ccode');
        var nexti = ucode.next();
        if(ucode.val().length==4){
            if(ucode.val()==''){
                ucode.attr({'data-content':'验证码不能为空，请输入！'});
                ucode.popover('show');
                nexti.attr({'class':'icon-tag'});
                return false;
            }
            $.ajax({
                type:'get',
                data:{'code':ucode.val()},
                url:'/admin/index/checkCode',
                success:function (obj) {
                    if(obj=='0'){
                        ucode.attr({'data-content':'验证码输入不正确，请重新输入！'});
                        ucode.popover('show');
                        nexti.attr({'class':'icon-tag'});
                        $("#SubmitData").attr({'disabled':true});
                    }else{
                        nexti.attr({'class':'icon-ok-sign green'});
                        ucode.popover('hide');
                        $("#SubmitData").removeAttr('disabled');
                        return true;
                    }
                }
            })
        }else if(ucode.val().length>4){
            ucode.attr({'data-content':'验证码输入不正确，请重新输入！'});
            ucode.popover('show');
            nexti.attr({'class':'icon-tag'});
            $("#SubmitData").attr({'disabled':true});
        }else{
            $("#SubmitData").attr({'disabled':true});
        }
    });
    $(document).on('click','#SubmitData',function () {
        var uname = $('#CName');
        var upwd = $('#CPwd');
        var ucode = $('#Ccode');
        var nexti = ucode.next();
        var uremember = $('#Remmber').is(':checked');
        if(uname.val() == ''){
            uname.attr({'data-content':'用户名不能为空！'});
            uname.popover('show');
            return false;
        }
        if(upwd.val()==''){
            upwd.attr({'data-content':'登录密码不能为空！'});
            upwd.popover('show');
            return false;
        }
        if(ucode.val() == ''){
            ucode.attr({'data-content':'验证码不能为空！'});
            ucode.popover('show');
            return false;
        }
        $(this).attr({'disabled':true});
        var reg=/^1[3|4|5|7|8][0-9]\d{4,8}$/;
        var condition;
        if(reg.test(uname.val())){
            condition = 'p';
        }else{
            condition = 'n';
        }
        $.ajax({
            type:'post',
            data:{'name':uname.val(),'pwd':upwd.val(),'code':ucode.val(),'remember':uremember,condition},
            url:'/admin/index/login',
            success:function (obj) {
                if(obj.code=='1'){
                    window.location.href = '/admin/index/index';
                }else{
//                        history.go(0);
                    uname.attr({'data-content':obj.msg});
                    uname.popover('show');
                    upwd.val("");
                    ucode.val("");
                    refreshVerify();
                    nexti.attr({'class':'icon-tag'});
                    return false;
                }
            }

        });
    });
});