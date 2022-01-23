<script>
//Pagination
pageSize = 4;

showPage = function(page) {
  $('.article-block').hide();
  $('.article-block:gt('+((page-1)*pageSize)+'):lt('+(page)*(pageSize-1)+')').show();
   $('.article-block:eq('+((page-1)*pageSize)+')').show();
}

$("#pagin li").click(function() {
  $("#pagin li").removeClass("active");
	$(this).addClass("active");
	showPage(parseInt($(this).text())) 
});
showPage(1);
</script>