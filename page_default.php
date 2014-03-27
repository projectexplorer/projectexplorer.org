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
                        Upper Elementary
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
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/71038102?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
        </section>
        <section class="half featured last">
            <h2>What's new?</h2>
            <article>
                <p>
                    <span class="dateline">Mar. 2014:</span> We&rsquo;ve got a whole new look! Check out the new site and let us know what you think by tweeting us <a href="https://twitter.com/projectexplorer">@projectexplorer</a>.
                </p>
            </article>
            <article>
                <p>
                    <span class="dateline">Jan. 2014:</span> Belmond Hotels joins ProjectExplorer.org as sponsor of our upcoming Peru series. Filming begins November 2014, and will take place in Lima, Sacred Valley, and Machu Picchu.</a>
                </p>
            </article>
            <article>
                <p>
                    <span class="dateline">Dec. 2013:</span> We&rsquo;re moving (our videos!) All episodes will now be hosted on Vimeo. Find us at <a href="http://vimeo.com/projectexplorer">vimeo.com/projectexplorer</a>.
                </p>
            </article>
        </section>
    </div>	
		
	<?php include('includes/include-footer.php') ?>
	
	<?php include('includes/include-scripts.php') ?>
</body>
</html>