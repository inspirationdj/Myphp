window.onload=function(){
  code();
  var q=document.getElementById('q');
  var qa=q.getElementsByTagName('a');
    qa[0].onclick=function(){
        window.open('q.php?num=1&path=qpic/1/','q','width=400,height=400,scrollbars=1');
    };
    qa[1].onclick=function(){
        window.open('q.php?num=1&path=qpic/2/','q','width=600,height=500,scrollbars=1');
    };qa[2].onclick=function(){
        window.open('q.php?num=1&path=qpic/3/','q','width=450,height=700,scrollbars=1');
    };



};