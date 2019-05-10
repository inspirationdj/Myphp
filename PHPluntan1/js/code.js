function code(){
    var code = document.getElementById('code');
    code.onclick=function(){
        this.src='recode.php?tm='+Math.random();

    };

}