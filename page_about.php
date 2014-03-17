<?php $sectionLocation="about"; $pageLocation="about"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">
	 <?php $pageLocation="about"; include('includes/include-header.php'); ?>
	
	
	<txp:if_individual_article>
		<article>
    		<txp:article form="about_detail" />
    	</article>
	<txp:else />
		<div class="wrapper">
			<div class="twothird">
				<h2>Our Mission</h2>
				<p>To bring the world into the classroom with free multimedia content and lesson plans that improve students' global awareness and cross cultural understanding.</p>
				<h3>What is ProjectExplorer.org</h3>
				<p>Founded in 2003, ProjectExplorer.org* was a pioneer in creating and distributing online video for student in a time when web video was, at best, an experiment. Today our growing catalog includes more than 400 original videos and 1,500+ documents. Nearly 5 million people have used our online materials to become more globally aware.</p>
				<p>ProjectExplorer.org covers a wide range of interrelated subjects, connecting U.S. and World History, Literature, Music, Language, Arts, Social Studies and Sciences in a way that helps students for lasting links between lessons. ProjectExplorer.org also provides lesson plans at three academic levels that adhere to National Curriculum Standards or Common Core Standards.

				<h2>Awards &amp; Recognitions</h2>
				<p>ProjectExplorer.org founder Jenny M. Buccos recognized as one of the <strong>National School Boards Association's</strong> 2012-2013 <strong>"20 to Watch"</strong>.</p>
				<p>ProjectExplorer.org founder Jenny M. Buccos named 2012 <strong>White House Champion of Change</strong>.</p>
				<p>2011 <strong>GOLD Parents' Choice Award</strong> for the highest production standards and universal human values.</p>
				<p>2011 <strong>Non-profit Standard of Excellence Award</strong> from the web marketing association.</p>
				<p>2010 winner of <strong>Best Use of Educational Video</strong> for EduBlogs.</p>
				<p>2010 <strong>National Award for Citizen Diplomacy</strong> for ProjectExplorer.org's Jenny M. Buccos. The U.S. Center for Citizen Diplomacy recognized Buccos for her exemplary work as a citizen diplomat.</p>
				<p>2009 <strong>Top Pick Website</strong> by Education Week Magazine for innovative approach to tech in classroom instruction</p>
				<p>2009 <strong>GOLD Parents' Choice Award</strong> for the highest production standards and universal human values.</p>
				<p class="footnote">*ProjectExplorer LTD. is a 501(c) non-profit organization incorporated in New York.</p>
			</div>
			<div class="sidebar sidebar--about third last">
				<a href="https://npo.justgive.org/nonprofits/donate.jsp?ein=56-2380398" class="button">Donate Now</a>
			</div>	
		</div>
	</txp:if_individual_article>
			
		</article>
		
	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>