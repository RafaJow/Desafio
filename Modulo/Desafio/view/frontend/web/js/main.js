require(['jquery'],function($){
    $(document).ready(function() {
        console.log('teste 111');

        let url = "http://lojanova.local/rest/V1/custom/custom-api/store";
        console.log("aaa");
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": url,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json",
                "Cache-Control": "no-cache",
                "cache-control": "no-cache"
            },
            beforeSend: function (xhr){},
            success: function(response){

                response = $.parseJSON(response);

                if($('button')[0] != undefined){
                    var color ="#"+response.color;
                    $('button').css('background',color);
                }
            },
            error: function (xhr, status, errorThrown) {
                console.log('Error happens. Try again.', errorThrown);
            }
        }
        $.ajax(settings).done(function (response) {
        });
    });
})