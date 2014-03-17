<?php $sectionLocation="levels"; $pageLocation="levels"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">		
    <div class="wrapper">

        <?php include('includes/include-header.php'); ?>

    	<txp:if_individual_article>

            <txp:if_section name="levels">

                <article>
                    <txp:article form="levels_detail" />
                </article>

            <txp:else />

                <section class="banner full">
                    <h2>Upper Elementary</h2>
                    <p><a href="/levels/" class="back-link">&larr; Go back to the Upper Elementary page</a></p>
                </section>

        		<article>
        			<txp:article form="article_detail" />
        		</article>
            </txp:if_section>

    	<txp:else />

    		<h2>Levels_list</h2>
    		<txp:article form="levels_list" pgonly="0" status="4" />
    		<txp:article_list form="levels_list" status="live" />

    	</txp:if_individual_article>
	
    </div> <!-- END .wrapper -->

	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>