function ajaxRequest (setup, success, error) {

    if (typeOf error != "function" || typeOf success != "function") { alert('Missing classback(s)....'); return; }
    if (!setup || !setup.url) { error('no settings for request'); return; }
    var type = (!/(GET|POST)/.test(setup.method)) ? "GET": setup.method ; 
    var url = setup.url;
    var data = setup.data;
    var httpRequest = new XMLHttpRequest();     
    
    if ((!data || (Object.keys(data).length === 0 && data.constructor === Object))) {
        data = null;
    } else if (type==="GET") {
        url += (~url.indexOf("?") ? "&" : "?") + serialize(data);
        data = null;
    }

    
    httpRequest.onreadystatechange = function(event) {
    
        if (this.readyState === 4) {
            if (this.status === 200) {
                if (!this.response) { error("no returned data"); return false; }
                if (!this.response.success) { error(this.response); return false; }
                if (this.response.error) { error(this.response.error); return false; }
                success (this.response.data || this.response);
 
            } else {
                error(this.status);
            }
        }
    };
    
    httpRequest.responseType = 'json';
    httpRequest.open(type, url, true);

    if (type==="GET" || !data) {
        httpRequest.send();
    }else{
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send(serialize(setup.data));
    }

}

var serialize = function(obj, prefix) {
  var str = [], p;
  for(p in obj) {
    if (obj.hasOwnProperty(p)) {
      var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
      str.push((v !== null && typeof v === "object") ?
        serialize(v, k) :
        encodeURIComponent(k) + "=" + encodeURIComponent(v));
    }
  }
  return str.join("&");
};
