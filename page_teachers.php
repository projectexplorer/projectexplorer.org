<?php $sectionLocation="teachers"; $pageLocation="teachers"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">		
    <div class="wrapper">

        <?php include('includes/include-header.php'); ?>

        <txp:if_section name="teachers">

            <article>
                <txp:article limit="1" form="levels_detail" status="sticky"  />
            </article>

        <txp:else />

    		<article>
    			<txp:article form="article_detail" />
    		</article>
            
        </txp:if_section>

	
    </div> <!-- END .wrapper -->

	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>