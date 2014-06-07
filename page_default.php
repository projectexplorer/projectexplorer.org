<?php $sectionLocation="home"; $pageLocation="home"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">

    <div class="wrapper">
    	
		 <?php include('includes/include-header.php'); ?>
	
            <txp:if_individual_article>
                <article>
                    <txp:article form="index_detail" />
                </article>
            <txp:else />
                    <txp:article_custom limit="1" form="index_detail" status="sticky" section="index"/>
            </txp:if_individual_article>

    </div>	
		
	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>