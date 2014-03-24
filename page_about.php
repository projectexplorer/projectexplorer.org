<?php $sectionLocation="about"; $pageLocation="about"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">
	 <?php $pageLocation="about"; include('includes/include-header.php'); ?>
	
	
	<txp:if_individual_article>
		<article>
    		<txp:article form="about_detail" />
    	</article>
	<txp:else />
		<article>
			<txp:article limit="1" form="about_detail" status="sticky" />
		</article>

	</txp:if_individual_article>

	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>