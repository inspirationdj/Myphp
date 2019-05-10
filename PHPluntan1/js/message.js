window.onload=function(){
    code();
    var fm = document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        //验证码验证
        if(fm.code.value.length!=4){
            alert('验证码必须是4位');
            fm.code.focus();
            return false;
}
};
};