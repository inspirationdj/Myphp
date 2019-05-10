//等待网页加载完毕再执行
 window.onload=function(){
    var faceimg=document.getElementById('faceimg');
    //var code = document.getElementById('code');
    faceimg.onclick=function(){
        window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
    };
     //alert("已经加载好了");
     // code.onclick=function(){
     //     this.src='recode.php?tm='+Math.random();
        code();
//表单验证
     var fm=document.getElementsByTagName('form')[0];
     alert(fm.name);
//密码验证
      if(fm.password.value<6){
         alert('密码不得小于6位');
          fm.password.value='';//清空
          fm.password.focus();//将焦点移至表单字段
          return false;
      }
     //邮箱验证
      if(!/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/.test(fm.email.value)){
          alert('邮箱格式不正确');
          fm.email.value='';
          fm.email.focus();
          return false;
      }


};