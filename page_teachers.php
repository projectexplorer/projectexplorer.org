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
                    db_close();
                ?>


                <txp:article form="teachers_detail" />

            </txp:if_section>

        <txp:else />
            <div class="twothird">
                <txp:smd_if_tag_list>
                    <txp:smd_tag_list type="file" wraptag="h2" break="">
                        Lesson plans in <txp:smd_tag_name title="1" />
                    </txp:smd_tag_list>
                
                    <txp:smd_related_tags wraptag="div" break="p" type="file">
                        <txp:smd_if_tag type="file">
                            <span class="lesson-filename"><txp:file_download_link><txp:file_download_name title="0" /></txp:file_download_link>:</span> <txp:file_download_description />
                        </txp:smd_if_tag>
                    </txp:smd_related_tags>
                </txp:smd_if_tag_list>

                <txp:smd_if_tag type="file">
                    <!--selected tag above-->
                <txp:else />
                    [ default content for both teachers / lessons goes here ]
                </txp:smd_if_tag>
            </div>
            <div class="sidebar sidebar--about third last">
                <h3>Available Subjects</h3>
                <txp:smd_tag_list type="file" showall="1">
                  <a href="/lessons/file/<txp:smd_tag_name title="0" />"><txp:smd_tag_name title="1" /> </a>
                </txp:smd_tag_list>
            </div>


        </txp:if_individual_article>
    
    </div> <!-- END .wrapper -->

    <?php include('includes/include-footer.php') ?>
    
    <?php include('includes/include-scripts.php') ?>
</body>
</html>