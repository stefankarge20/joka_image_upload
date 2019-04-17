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
                        <div class="row" v-for="articleId in selectedProducts">
                            <div class="col-md-12">
                                Artikel: {{articleId}}
                            </div>
                            <div class="col-md-4" v-for="image in currentArticleImages">
                                <div v-if="articleId==image.productId">
                                    <div class="row border-top border-right border-left">
                                        <div class="col-md-12">
                                            <img v-bind:src="image.name" width="100%" height="300px"/>
                                        </div>
                                    </div>
                                    <div class="row border-bottom border-right border-left">
                                        <div class="col-md-10">
                                            <select v-model="usage" class="form-control" style="height: 35px" @click="changeImageUsage(articleId, image.id, usage)">
                                                <option>Frontbild</option>
                                                <option>Text-Zeichnung</option>
                                                <option>Verpackung</option>
                                                <option>anderes</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary pull-right" @click="deleteImage(articleId, image.id)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="/joka/api/image/upload.php" method="post" enctype="multipart/form-data" class="col-md-6">
                            <input id="input-b1" name="fileToUpload" type="file" class="file" data-browse-on-zone-click="true">
                            <input name="productId" type="text" hidden="hidden" value="6">

                        </form>


                    </div>
                </div>
            </div>

        </div>
    </div>
<?php include("footer.php"); ?>