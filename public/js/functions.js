function deleteNews(newsId){
    var url = 'delete_news/' + newsId;

    console.log(url);
    var request = $.ajax({
        url: url,
        type: 'post',
        dataType: 'html'
    });

    request.done( function ( data ) {
        $('#deleteButton').html( data );
    });

    request.fail( function ( jqXHR, textStatus) {
        console.log( 'Sorry: ' + textStatus );
    });
}
$(document).ready(function(){

    var i;
    var ma = 2;
    var musicID = 3;
    //hides dropdown content
   $(".type").hide();

    //unhides first option content
    $('#movie').show();
    $("#format").show();
    for (i=0; i < ma; i++)
        $("#ma" + i).show();


    //listen to dropdown for change
    $("#type").change(function(){
        //rehide content on change
        $('.type').hide();

        //unhides current item
        if($(this).val() == "movie" || $(this).val() == "anime") {

            $("#" + $(this).val()).show();
            for (i=0; i < ma; i++)
                $("#ma" + i).show();
            $("#format").show();
        }else{
            $("#format").hide();
            for (i=0; i < musicID; i++)
                $("#music" + i).show();
        }
    });

});