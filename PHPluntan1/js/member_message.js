window.onload=function(){
    var all=document.getElementById('all');
    var form=document.getElementsByTagName('form')[0];
    all.onclick=function(){
        //form.elements.length获取表单内的所有表单
        //checked表示已选
       for( var i=0;i<form.elements.length;i++){
           if(form.elements[i].name!='chkall'){
               form.elements[i].checked=form.chkall.checked;
           }
       }
    };
    form.onsubmit=function(){
        if(confirm('确定删除？')) {
            return true;
        }else{
            return false;
        }
    };
};