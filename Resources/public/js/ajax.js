var BsSelectAjaxProcessor = {
    baseRequest: function(route, data, callback){
        $.ajax({
            type: "POST",
            url: route,
            data: data,
            cache:false,
            success: function(response)
            {
                if (typeof(callback) == "function"){
                    callback(response);
                }
                $(".loading").addClass("hidden");
            }
        });
    },

    initAjax: function(element, config) {
        var parent = element.parent();
        var searchBar = parent.find('.bs-searchbox').find("input[type='text']");

        searchBar.on('keyup', function() {
            var toSearch = toSearch.val();
            console.log(toSearch);
        });
    }


}