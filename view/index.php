<?php include("header.php"); ?>

    <div id="joka-demo">
        <div class="row">
            <div class="col-12" style="background: aquamarine">Headline</div>
        </div>
        <div class="row">
            <?php include("leftMenue.php"); ?>

            <div class="col-10" style="background: dimgrey" v-if="currentArticleID == ''">
                <section id="new-product" class="container section-data" >
                    <h2>{{categoryName}} Artikel ({{currentArticles.length}}) {{currentArticleID}} -</h2>
                    <div class="row">
                        <product-demo v-for="article in currentArticles" v-bind:key="article.id"
                                      v-bind:article="article" v-bind:categoryname="categoryName"></product-demo>
                    </div>
                </section>
            </div>
           <article-view v-else v-bind:key="currentarticle.id"
                         v-bind:currentarticle="currentarticle"></article-view>
        </div>
        <div class="col-1" style="background: darkorange">
            Info
        </div>
    </div>
<?php include("footer.php"); ?>