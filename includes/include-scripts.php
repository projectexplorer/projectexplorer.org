<!-- external scripts -->

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">
	_uacct = "UA-1017041-1";
	urchinTracker();
</script>

<!-- ready scripts -->
<script type="text/javascript">
	$(document).ready(function() {
		// add hooks to all links in the levels section to launch in FancyBox
		$(".articles article a").attr("class","various").attr("data-fancybox-type","iframe");
		// modal attributes
		$(".various").fancybox({
			maxWidth	: 400,
			maxHeight	: 600,
			fitToView	: false,
			width		: '70%',
			height		: '70%',
			autoSize	: false,
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