function obj2str(data) {
    data.t = new Date().getTime();
    let res = [];
    for(let key in data) {
        //url中对中文参数转码
        res.push(encodeURIComponent(key)+"="+encodeURIComponent(data[key])); //[username=dj,userpwd=123456];
    }
     return res.join("&");//username=dj&userpwd=123456
}
function ajax(option) {
    //0.将对象转换为字符串
    let str = obj2str(option.data);//key=value&key=value;
    //1.创建一个异步对象
    let xhr;
    let timer;
    if(window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if(window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    //2.设置请求方式和请求地址
    /*
    * method：请求的类型；GET 或 POST
    * url：文件在服务器上的位置
    * async：true（异步）或 false（同步）
    * */
    if(option.type.toLowerCase() === "get") {
        xhr.open(option.type, option.url+"?"+str,true);
        //3.发送请求
        xhr.send();
    }else {
        xhr.open(option.type,option.url,true);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send(str);
    }
    //4.监听状态的变化
    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4) {
            clearInterval(timer);
            //判断是否请求成功
            if(xhr.status >=200 && xhr.status<300 ||xhr.status===304 ||xhr.status ===0) {
                //5.成功后调用success处理返回结果
                option.success(xhr);
            } else {
                option.error(xhr);
            }
        }
    };
    //判断外界是否传入超时时间
    if(option.timeout) {
        timer = setTimeout(function() {
            alert("请求超时");
            xhr.abort();
            clearInterval(timer);
        }, option.timeout);
    }
}