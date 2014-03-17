<?php $sectionLocation="home"; $pageLocation="home"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">

    <div class="wrapper">
    	
		 <?php include('includes/include-header.php'); ?>
	
        <section class="banner full">
            <h1>Where would you like to go today?</h1>
            <img src="/img/home-map.gif" alt="Where would you like to go today?" />
            <p>
                Explore the world without leaving your couch or classroom. Follow the ProjectExplorer.org film crew as they travel back in time to ancient cities, come face-to-face with ferocious creatures, and take part in local celebrations. <br />No passport or plane ticket needed.
            </p>
            <h2>Just pick a grade level to start your virtual adventure</h2>
        </section>
        <section>
            <div class="third promo level-elementary">
                <a href="/levels/upper-elementary">
                    <img src="/img/home-ue.jpg" alt="giraffe" />
                </a>
                <h3>
                    <a href="/levels/upper-elementary">
                        Upper elementary
                    </a>
                </h3>
            </div>
            <div class="third promo level-middle">
                <a href="/levels/middle-school">
                    <img src="/img/home-ms.jpg" alt="berries" />
                </a>
                <h3>
                    <a href="/levels/middle-school">
                        Middle School
                    </a>
                </h3>
            </div>
            <div class="third last promo level-high">
                <a href="/levels/high-school">
                    <img src="/img/home-hs.jpg" alt="leaves" />
                </a>
                <h3>
                    <a href="/levels/high-school">
                        High School
                    </a>
                </h3>
            </div>
        </section>
        <section class="half featured">
            <h2>Featured video</h2>
            <img src="http://www.fillmurray.com/g/450/300" alt="" />
        </section>
        <section class="half featured last">
            <h2>What's new?</h2>
            <article>
                <p>
                    <span class="dateline">Apr. 2013:</span> Four Seasons hotels in Nevis and Singapore will host team ProjectExplorer.org this ear during British Empire series filming.
                </p>
            </article>
            <article>
                <p>
                    <span class="dateline">Mar. 2013:</span> The team heads to Montreal to film the first part of the British Empire series!
                </p>
            </article>
            <article>
                <p>
                    <span class="dateline">Dec. 2012:</span> ProjectExplorer.org partners with Vimeo to share our video work.
                </p>
            </article>
        </section>
    </div>	
		
	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>