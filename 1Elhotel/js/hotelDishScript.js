jQuery(document).ready(function($){

    $.get("xmlfiles/dish.xml", function(data){
        var dish_data = $(data).find('dishes');
        var display_template = $(document).find("#display-template");

        $(dish_data).children("dish").each(function(i, el){
            //console.log(el);

            var dish_html = display_template.clone(); 
            var dishData = $("<ul></ul>");

            var _dishId = $(el).children("dishId").text();
            var _dishName = $(el).children("dish_name").text();
            var _dishImg = $(el).children("media").text();
            var _dishPrice = $(el).children("price").text();
            var _dishCategory = $(el).attr("category");


            $(dish_html).attr("id", "dish-"+ _dishId);
            $(dish_html).find(".img-dish-cover").html('<img class="card-img-top" src="project_images/'+ _dishImg +'" />');
            
            $(dish_html).find(".card-title").text(_dishName);
            $(dish_html).find(".card-subtitle").text(_dishPrice);

            $(dishData).append('<li>Category: '+ _dishCategory +'</li>');

            $(dish_html).find(".card-text").html(dishData);

            $(dish_html).removeClass("d-none").appendTo("#dish-list");

        });

    })

});

