<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <style type="text/css">
        .card-columns {
            column-count: 4;
        }

    </style>
    <div class="container">
        <div class="gallery"></div>
        <hr>
        <nav aria-label="...">
          <ul class="pagination">
            <li class="page-item">
              <a id="previous" class="page-link" href="#">Previous</a>
            </li>
            <!-- <li class="page-item"><a class="page-link" href="">1</a></li>
            <li class="page-item active">
              <span class="page-link">
                2
                <span class="sr-only">(current)</span>
              </span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li> -->
            <li class="page-item">
              <a id="next" class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
    </div>

    <script id="entry-template" type="text/x-handlebars-template">
    <div class="card-columns">
    {{#each photo}}
        <div class="card">
            <img class="card-img-top img-fluid" src='{{source}}' alt=''>
            <div class="card-block">
                <a href="{{link}}"><span class="btn btn-primary"><i class="fas fa-thumbs-up"></i></span></a>
                <!-- <p class="card-title">{{created_time}}</p> -->
            </div>
        </div>
    {{/each}}
    </div>  
    </script>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="js/handlebars-v4.0.11.js"></script>
    <script>
    $(function(){

        getfbphotos();

        $(".page-link").on("click", function(e){
            getfbphotos($(this).attr("href"));
            return false;
        })

        function getfbphotos(link){
            console.log(link);
            $.ajax({
                url: "ajax.php",
                type: "post",
                data: {'link' : link},
                dataType: "json"
            }).done(function(data){
                console.log(data);
                var source   = document.getElementById("entry-template").innerHTML;
                var template = Handlebars.compile(source);
                var html    = template(data);
                
                $(".gallery").html(html);

                if(data.paging.next){
                    $("#next").attr("href",data.paging.next);
                }

                if(data.paging.previous){
                    $("#previous").attr("href",data.paging.previous);
                }
            })
        }


        // function get(link){
        //     return $.getJSON(link);
        // }
    })
    </script>
</body>
</html>