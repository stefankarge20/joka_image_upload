<?php include("header.php"); ?>
    <div id="joka-demo">
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
                            <div class="tab-pane fade in active" id="tabArticleTree">
                                <ul id="demo">
                                    <tree-item class="item" :item="treeData" :selectedproducts="selectedProducts"></tree-item>
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
                                                   placeholder="Kategorie, Kollektion, EAN-Nummer, Produktname">
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
                                <button class="btn btn-primary pull-right" @click="selectAll(true)">
                                    <span class="glyphicon glyphicon-plus"></span> Alles auswählen
                                </button>&nbsp;
                                <button class="btn btn-primary pull-right"  @click="selectAll(false)">
                                    <span class="glyphicon glyphicon-minus"></span> Alles abwählen
                                </button>
                                <div class="col-md-12">
                                    <h3>Ausgewählte Artikel:</h3>
                                    <ul>
                                        <li v-for="article in getSelectedArticles()">{{article.productName}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul>
            </ul>
            <div class="col-md-5">
                <div class="card card-default" style="min-height: 600px">
                    <div class="card-header"><h3>Ausgewählte Bilder zu Artikel</h3></div>
                    <div class="card-body">
                        <div class="row" v-for="article in  getSelectedArticles()">
                            <div class="col-md-12" style="min-height: 50px"></div>
                            <div class="col-md-12">
                                <h4>Bilder zu Artikel: {{article.productName}}</h4>
                            </div>
                            <div class="col-md-4" v-for="image in currentArticleImages"
                                 v-if="article.productId==image.productId">
                                <div class="row border-top border-right border-left">
                                    <div class="col-md-12">
                                        <img v-bind:src="image.name" width="100%" height="300px"/>
                                    </div>
                                </div>
                                <div class="row border-bottom border-right border-left">
                                    <div class="col-md-10">
                                        <select v-model="image.usageFor" class="form-control" style="height: 35px"
                                                @change="changeImageUsage(image)">
                                            <option value="Verwendungszweck">Verwendungszweck</option>
                                            <option value="Frontbild">Frontbild</option>
                                            <option value="Text-Zeichnung">Text-Zeichnung</option>
                                            <option value="Verpackung">Verpackung</option>
                                            <option value="anderes">anderes</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary pull-right" @click="deleteImage(image)">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="min-height: 75px"></div>
                            <div class="col-md-12">
                                <h3>Weiteres Artikelbild für folgende Artikel hochladen:</h3>
                                <ul>
                                    <li v-for="article in getSelectedArticles()">{{article.productName}}</li>
                                </ul>
                            </div>
                            <form v-bind:action="urlImageUpload" method="post" enctype="multipart/form-data"  class="col-md-6">
                                    <input id="input-b1" name="fileToUpload" type="file" class="file" data-browse-on-zone-click="true">
                                    <select class="form-control" style="height: 35px" name="usageFor">
                                        <option value="Verwendungszweck" selected="selected">Verwendungszweck</option>
                                        <option value="Frontbild">Frontbild</option>
                                        <option value="Text-Zeichnung">Text-Zeichnung</option>
                                        <option value="Verpackung">Verpackung</option>
                                        <option value="anderes">anderes</option>
                                    </select>
                                <input name="productIds" type="text" hidden="hidden" v-bind:value="getUploadParams()">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
<?php include("footer.php"); ?>