window.onload=function(){
    var up=document.getElementById('up');
    up.onclick=function(){
    centerWindow('upimg.php?dir='+this.title,'up','100','400');
    };
    // var fm=document.getElementsByTagName('form')[0];
    // fm.onsubmit=function(){
    //     if(fm.name.value.length<2||fm.name.value.length>20){
    //         alert('图片名不得小于2位或者大于20位');
    //         fm.title.focus();
    //         return false;
    //     }
    //     if(fm.url.value==''){
    //         alert('地址不得为空');
    //         fm.url.focus();
    //         return false;
    //     }
    //     return false;
     //};
};

function centerWindow(url,name,height,width){
    var top=(screen.width-width)/2;
    var left=(screen.height-height)/2;
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}