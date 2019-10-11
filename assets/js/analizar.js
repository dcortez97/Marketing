var loadJsonFromPHP = function(data) {
    //console.log(data);
         //console.log(data);
         for (let i = 0; i < data.length; i++) {
           // console.log( data[i].comentario);

            (function(ind) {
                setTimeout(function(){
                    //console.log(ind);
                    var settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "https://api.meaningcloud.com/sentiment-2.1",
                        "method": "POST",
                        "headers": {
                            "content-type": "application/x-www-form-urlencoded"
                        },
                        "data": {
                            "key": "056dcf36f4818a5acf189f4a6012e4e4",
                            "lang": "es",
                            "txt": data[i].comentario,
                            "txtf": "plain"
                        }
                    }
                      $.ajax(settings).done(function (response) {
                          console.log(response);
                      });
                }, 1000 + (1000 * ind));
            })(i);

            
        }
}
