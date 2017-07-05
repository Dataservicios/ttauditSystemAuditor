/**
 * Created by Jaime on 17/07/2016.
 */
function ajaxJson(url_base,url,params, functionCreateChart , divChart,divLoading,message) {
    var url_base = url_base;
    var url = url ;
    var divChart = divChart ;
    var divLoading = divLoading
    var loading= "<div class='" + divLoading +"'><img src='" + url_base +  "/img/loading.gif" + "' ></div>";

    $("#"+divLoading).html(loading);
    $.post(url , params,  function(data) {
            // alert( "success" + data );
            //console.log ("success => " + data[0].fullname);
            console.log (data.toString());
//                    alert( "Enví petición, primer success" );
//                    $.each(data, function(i, item){
//                        console.log (item.fullname);
//                    });
            //$("."+divLoading).remove();

        })
        .done(function(data) {
            // alert( "second success" );
            console.log (data);
            functionCreateChart(data, divChart,url_base);
        })
        .fail(function() {
            // alert( "error" );
            $("#"+divLoading).html("<div class='" + divLoading +"'>message</div>");

        })
        .always(function() {
            // alert( "finished" );
            $("."+divLoading + " > img ").hide();
        });

}