<?php include("header.php"); ?>
    <div class="container" id="joka-demo">
        <div class="row">
            <div class="card-body">
                <div class="col-md-6">
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabArticleTree" data-toggle="tab">Artikelbaum</a></li>
                                <li><a href="#tabSearch" data-toggle="tab">Suche</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content" style="min-height: 250px">
                                <div class="tab-pane fade in active" id="tabArticleTree">
                                    <ul id="demo">
                                        <tree-item class="item" :item="treeData"></tree-item>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="tabSearch">
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="search">Produktsuche über:</label>
                                            <div class="ui-widget">
                                                <input type="text" class="form-control" id="search"
                                                       v-on:click="productSelect()"
                                                       v-on:keyup="productSearchChange()"
                                                       placeholder="Produktname, EAN-Nummer, Kollektion">
                                            </div>

                                        </div>
                                    </form>
<!--                                    <div class="loader" id="loaderSearch" style="right: 0px"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card card-default" style="min-height: 350px">
                        <div class="card-header">Bildbearbeitung</div>
                        <div class="card-body">
                            lorem ipsum
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>