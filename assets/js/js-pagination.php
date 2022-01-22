<script src="jquery-3.5.1.min.js"></script>
<script>
    //Pagination
    articlesDiv = document.getElementsByClassName("article-block");
    pageSize = articlesDiv.length;

    var pageCount = $(".article-block").length / pageSize;

    for (var i = 0; i < pageCount; i++) {
        if (i == 0) {
            $("#pagin").append('<li class="page-item active"><a class="page-link" href="#">' + (i + 1) + '</a></li> ');

        } else {
            $("#pagin").append('<li class="page-item"><a class="page-link" href="#">' + (i + 1) + '</a></li> ');

        }
    }

    showPage = function(page) {
        articlesDiv.forEach(art => {
            if (n >= pageSize * (page - 1) && n < pageSize * page)
                art.style.visibility = 'visible';

        });
    }

    showPage(1);

    document.getElementsByClassName("page-link").forEach(link => addEventListener("click", function() {
        document.getElementById("demo").innerHTML = "Hello World";
    }));

    $("#pagin li a").click(function() {
        $("#pagin li").removeClass("active");
        $(this).addClass("active");
        showPage(parseInt($(this).text()))
    });
</script>