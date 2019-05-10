window.onload=function(){
  code();
    //表单验证
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){

    }
    //密码验证
    if(fm.password.value!='') {
        if (fm.password.value < 6) {
            alert('密码不得小于6位');
            fm.password.value = '';//清空
            fm.password.focus();//将焦点移至表单字段
            return false;
        }
    }
    //邮箱验证
    // if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)){
    //   alert('邮箱格式不正确');
    //   fm.email.value='';
    //   fm.email.focus();
    //   return false;
    // }
    //验证码验证
    // if (fm.code.value.length != 4) {
    //      alert('验证码必须是4位');
    //      fm.code.value = '';//清空
    //      fm.username.focus();//将焦点移至表单字段
    //     return false;
    //  }
    return true;

};