<?php $sectionLocation="levels"; $pageLocation="levels"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">		
    <div class="wrapper">

        <?php $pageLocation="levels"; include('includes/include-header.php'); ?>

    	<txp:if_individual_article>

    		<article class="explorer-detail">
    			<txp:article form="explorers_detail" />
    		</article>

    	<txp:else />
            <div class="explorers">
    		  <h2><txp:section title="1" /></h2>
    		  <txp:article form="explorers_list" limit="50" pgonly="0" />
            </div>

    	</txp:if_individual_article>
	
    </div> <!-- END .wrapper -->

	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>