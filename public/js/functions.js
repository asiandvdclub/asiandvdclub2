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