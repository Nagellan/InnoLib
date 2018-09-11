$(function() {
    $(".search-button").click(function() { 
        var searchString = $("#search-box").val(); // получаем то, что написал пользователь
        var data = 'query='+ searchString; // формируем строку запроса
            $.ajax({ // делаем ajax запрос
                type: "POST",
                url: "search.php",
                data: data,
                beforeSend: function(html) { // запустится до вызова запроса
                    $("#results").html('');
                    $("#results").show();
                    $(".word").html(searchString);
               },
               success: function(html){ // запустится после получения результатов
                    $("#results").show();
                    $("#results").append(html);
              }
            });
        return false;
    });
});

