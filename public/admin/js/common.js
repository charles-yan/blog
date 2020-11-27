function joinParams(params){
    var str = '';
    for (var key in params) {
        str += key + '=' + params[key] + '&';
    };
    str = str.slice(0, -1);
    return str;
}
export{joinParams}
