(function($)
{
	"use strict";
	$(document).ready(function() {
		$('body').on('click','.sv-post-like',function(event){
			event.preventDefault();
			var heart = $(this);
			var post_id = heart.data("post_id");
			heart.html("<i class='icon-like'></i><i class='icon-gear'></i>");
			$.ajax({
				type: "post",
				url: ajax_var.url,
				data: "action=sv-post-like&nonce="+ajax_var.nonce+"&th_post_like=&post_id="+post_id,
				success: function(count){
					if( count.indexOf( "already" ) !== -1 )
					{
						var lecount = count.replace("already","");
						if (lecount === "0")
						{
							lecount = "0";
						}
						heart.prop('title', 'Like');
						heart.removeClass("liked");
						heart.html("<i class='icon-unlike'></i><sup>"+lecount+"</sup>");
					}
					else
					{
						heart.prop('title', 'Unlike');
						heart.addClass("liked");
						heart.html("<i class='icon-like'></i><sup>"+count+"</sup>");
					}
				}
			});
		});
	});
})(jQuery)