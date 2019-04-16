<?php include("header.php"); ?>
    <div  id="joka-demo">
        <div class="row">
            <div class="col-md-5 offset-md-1">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabArticleTree" data-toggle="tab"><h3>Artikelbaum</h3></a></li>
                            <li><a href="#tabSearch" data-toggle="tab"><h3>Suche</h3></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content" style="min-height: 500px">
                            <button type="button" class="btn btn-success pull-right" @click="editArticleImage">
                                Artikelbilder bearbeiten
                            </button>
                            <div class="tab-pane fade in active" id="tabArticleTree">
                                <br/>
                                <ul id="demo">
                                    <tree-item class="item" :item="treeData"
                                               :selectedproducts="selectedProducts"></tree-item>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tabSearch">
                                <form role="form">
                                    <div class="form-group">
                                        <br/>
                                        <label for="search">Artikelsuche über:</label>
                                        <div class="ui-widget">
                                            <input type="text" class="form-control" id="search"
                                                   v-on:keyup="productSearchChange()"
                                                   placeholder="Kategorie, Kollektion, Produktname, EAN-Nummer">
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-striped custab">
                                    <thead>
                                    <tr>
                                        <th>Bearbeiten</th>
                                        <th>Kategorie</th>
                                        <th>Kollektion</th>
                                        <th>EAN</th>
                                        <th>Artikel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="match in searchMatches" @click="selectRow(match)"
                                        v-bind:class="{bold: match.selected}" style="cursor: pointer">
                                        <td><input type="checkbox" v-model="match.selected"></td>
                                        <td>{{match.categoryName}}</td>
                                        <td>{{match.collectionName}}</td>
                                        <td>{{match.eanNo}}</td>
                                        <td>{{match.productName}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-5">
                <div class="card card-default" style="min-height: 600px">
                    <div class="card-header"><h3>Ausgewählte Bilder zu Artikel</h3></div>
                    <div class="card-body">
                        <div v-for="id in selectedProducts">
                            Artikel: {{id}}
                        </div>
                        <h3>Weitere Bilder hochladen</h3>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true">
                            <input type="submit" value="Bild hochladen" name="submit" class="btn btn-success">
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
<?php include("footer.php"); ?>