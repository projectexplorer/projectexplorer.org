<div class="clear"></div>

    <txp:if_section name="high-school-and-beyond">
     <section class="banner full high-school">
        <h2><a href="/levels/high-school"><txp:section title="1"/></a></h2>
     </section>
    </txp:if_section>
    <txp:if_section name="middle-school">
     <section class="banner full <txp:section />">
        <h2><a href="/levels/middle-school"><txp:section title="1"/></a></h2>
     </section>
    </txp:if_section>
    <txp:if_section name="upper-elementary">
     <section class="banner full <txp:section />">
        <h2><a href="/levels/upper-elementary"><txp:section title="1"/></a></h2>
     </section>
    </txp:if_section>


<article class="twothird">
    <h1><txp:title /></h1>
    <txp:if_custom_field name="Vimeo primary">
        <div class="embed-container">
            <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo primary" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
    </txp:if_custom_field>
    <txp:body />

     <p class="signature"><txp:custom_field name="Author" /></p>
</article>
<aside class="third">
    <txp:if_custom_field name="Vimeo aside 1"> 
    <h3>More videos</h3>
        <script type="text/javascript">videos.push(<txp:custom_field name="Vimeo aside 1" />);</script>
        <figure id="<txp:custom_field name="Vimeo aside 1" />">    
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo aside 1" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <figcaption>&nbsp;</figcaption>
        </figure>
    </txp:if_custom_field>
    <txp:if_custom_field name="Vimeo aside 2"> 
        <script type="text/javascript">videos.push(<txp:custom_field name="Vimeo aside 2" />);</script>
        <figure id="<txp:custom_field name="Vimeo aside 2" />">    
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo aside 2" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <figcaption>&nbsp;</figcaption>
        </figure>
    </txp:if_custom_field>
    <txp:if_custom_field name="Vimeo aside 3"> 
        <script type="text/javascript">videos.push(<txp:custom_field name="Vimeo aside 3" />);</script>
        <figure id="<txp:custom_field name="Vimeo aside 3" />">    
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo aside 3" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <figcaption>&nbsp;</figcaption>
        </figure>
    </txp:if_custom_field>
    <txp:if_custom_field name="Vimeo aside 4"> 
        <script type="text/javascript">videos.push(<txp:custom_field name="Vimeo aside 4" />);</script>
        <figure id="<txp:custom_field name="Vimeo aside 4" />">    
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo aside 4" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <figcaption>&nbsp;</figcaption>
        </figure>
    </txp:if_custom_field>
    <txp:if_custom_field name="Vimeo aside 5"> 
        <script type="text/javascript">videos.push(<txp:custom_field name="Vimeo aside 5" />);</script>
        <figure id="<txp:custom_field name="Vimeo aside 5" />">    
            <div class="embed-container">
                <iframe src="//player.vimeo.com/video/<txp:custom_field name="Vimeo aside 5" />" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <figcaption>&nbsp;</figcaption>
        </figure>
    </txp:if_custom_field>
    <h3>More from <txp:category1 title="1"/></h3>

<txp:article_custom section='<txp:section />' category='<txp:category1 />' wraptag="ul">
<txp:if_article_id>
<li>&gt; <txp:title /></li>
<txp:else />
<li><txp:permlink><txp:title /></txp:permlink></li>
</txp:if_article_id>
</txp:article_custom>

    <h3>Choose a new adventure</h3>
    <txp:category_list wraptag="ul" break="li">
        <txp:article_custom limit="1" section='<txp:section/>' category='<txp:category/>'>
           <txp:permlink><txp:category title="1" /></txp:permlink>
        </txp:article_custom>
    </txp:category_list>
</aside>