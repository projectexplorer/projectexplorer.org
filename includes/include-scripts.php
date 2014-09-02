<!-- external scripts -->

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
	_uacct = "UA-1017041-1";
	urchinTracker();
</script>

<!-- ready scripts -->
<script type="text/javascript">

	function getRelatedVideo() {
		var vimeoInfo;
		var vimeoUrl = "http://vimeo.com/api/v2/video/";

		for (var i=0; i<videos.length; ++i){
			//get info for the video
			  $.ajax({
			     type: "GET",
			     url: vimeoUrl + videos[i] + '.json',
			     dataType: "jsonp",
			     success: function(obj) {
			       populateTitle(obj, 'vimeo-aside-'+i);
			     }
			  });
		}
	}

	function populateTitle(obj, parentid) {
		var vidtitle = obj[0].title;
		var vidthumb = obj[0].thumbnail_large;

		var fromindex = vidtitle.toLowerCase().indexOf("from");

		if(fromindex > 0){
			vidtitle = vidtitle.substring(0,fromindex);
		}

		$("#" + obj[0].id).find("figcaption").html(vidtitle);
		$("#" + obj[0].id).find("img").attr("src", vidthumb);
	}

	$(document).ready(function() {
		// get the sidebar videos we stashed in the header array
		getRelatedVideo();
		// add hooks to all links in the levels section to launch in FancyBox
		$(".articles article a").attr("class","various").attr("data-fancybox-type","iframe");
		// remove fancy box from the PDF links to lesson plans
		$("a[href$=.pdf]").removeAttr("data-fancybox-type");
		// modal attributes
		$(".various").fancybox({
			//maxWidth	: 400,
			//maxHeight	: 600,
			fitToView	: true,
			width		: '70%',
			height		: '70%',
			autoSize	: true,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});
		// initialize FancyBox as modal library
		$(".fancybox").fancybox();
	});
</script>

<!-- override scripts -->
<?php if($pageLocation == 'levels') { ?>
	<script>
		$(document).ready(function() {
			// page-level overrides
		});
	</script>
<?php }?>