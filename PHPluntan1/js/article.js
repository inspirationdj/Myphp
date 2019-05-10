window.onload=function(){
    var friend=document.getElementsByName('friend');
    var message=document.getElementsByName('message');
    var flower=document.getElementsByName('flower');
    code();
    var q=document.getElementById('q');
    var qa=q.getElementsByTagName('a');
    var re =document.getElementsByName('re');
    for(var i=0;i<re.length;i++){
        re[i].onclick=function(){
            document.getElementsByTagName('form')[0].title.value=this.title;
        };
    }
    qa[0].onclick=function(){
        window.open('q.php?num=1&path=qpic/1/','q','width=400,height=400,scrollbars=1');
    };
    qa[1].onclick=function(){
        window.open('q.php?num=1&path=qpic/2/','q','width=600,height=500,scrollbars=1');
    };qa[2].onclick=function(){
        window.open('q.php?num=1&path=qpic/3/','q','width=450,height=700,scrollbars=1');
    };


    for(var i=0;i<message.length;i++){
        message[i].onclick=function(){
            centerWindow('message.php?id='+this.title,'message',250,400);
        };
    }
    for(var i=0;i<friend.length;i++) {
        friend[i].onclick = function () {
            centerWindow('friend.php?id=' + this.title, 'friend', 250, 400);
        };
    }

    for(var i=0;i<flower.length;i++) {
        flower[i].onclick = function () {
            centerWindow('flower.php?id=' + this.title, 'flower', 250, 400);
        };
    }
};
function centerWindow(url,name,height,width){
    var top=(screen.width-width)/2;
    var left=(screen.height-height)/2;
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}