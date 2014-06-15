<?php $sectionLocation="articles"; $pageLocation="articles"; include('includes/include-head.php') ?>

<body class="<?php echo $sectionLocation ?>">       
    <div class="wrapper">

        <?php include('includes/include-header.php'); ?>

        <txp:if_individual_article>

            <txp:if_section name="levels">

                <article>
                    <txp:article form="levels_detail" />
                </article>

            <txp:else />

                <?php 
                    include('includes/db.php');
                    include('includes/pre.php');
                    include('includes/users.php');

                    if (user_isloggedin()) {
                            $firstname = user_getfirstname();
                            $lastname = user_getlastname();
                    }
                    else
                    {
                           echo '<script type="text/javascript">window.location.href="/about/login?url='.$_SERVER["REQUEST_URI"].'";</script>';
                    }
                ?>


                <txp:article form="teachers_detail" />

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