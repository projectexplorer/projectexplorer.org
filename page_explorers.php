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
    		  <h2>Explorers</h2>
    		  <txp:article form="explorers_list" pgonly="0" status="4" />
            </div>

    	</txp:if_individual_article>
	
    </div> <!-- END .wrapper -->

	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>