<?php include("header.php"); ?>

    <div id="joka-demo">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabArticleTree" data-toggle="tab">Artikelbaum</a></li>
                                <li><a href="#tabSearch" data-toggle="tab">Suche</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tabArticleTree">
                                        <ul id="demo">
                                            <tree-item class="item" :item="treeData"></tree-item>
                                        </ul>
                                    </div>
                                    <div class="tab-pane fade" id="tabSearch">
                                        suche
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#bild" data-toggle="tab">Bildberbeitung</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="bild">Bildberbeitung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!--        <div class="row">-->
    <!--            --><?php //include("leftMenue.php"); ?>
    <!---->
    <!--            <div class="col-10" style="background: dimgrey" v-if="currentArticleID == ''">-->
    <!--                <section id="new-product" class="container section-data" >-->
    <!--                    <h2>{{categoryName}} Artikel ({{currentArticles.length}}) {{currentArticleID}} -</h2>-->
    <!--                    <div class="row">-->
    <!--                        <product-demo v-for="article in currentArticles" v-bind:key="article.id"-->
    <!--                                      v-bind:article="article" v-bind:categoryname="categoryName"></product-demo>-->
    <!--                    </div>-->
    <!--                </section>-->
    <!--            </div>-->
    <!--            <article-view v-else v-bind:key="currentarticle.id"-->
    <!--                          v-bind:currentarticle="currentarticle"></article-view>-->
    <!--        </div>-->
    <!--        <div class="col-1" style="background: darkorange">-->
    <!--            Info-->
    <!--        </div>-->

<?php include("footer.php"); ?>