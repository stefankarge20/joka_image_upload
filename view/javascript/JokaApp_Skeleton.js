const urlArticles = "/joka/api/product/read.php";
const urlCategories = "/joka/api/category/read.php";
const urlReadCategory = "/joka/api/collection/read_category.php";
const urlCollectionArticles = "/joka/api/product/read_collections.php";
const urlSearch = "/joka/api/controller/search.php";
const urlImages = "/joka/api/image/read.php";
const urlChangeImageUsage = "/joka/api/image/patch.php";

new Vue({
    el: '#joka-demo',
    data: {
        articles: [],
        categories: [],
        categoryName: "",
        currentArticles: [],
        currentArticleID: "",
        currentarticle: {},
        treeData: {},
        searchMatches: [],
        selectedProducts: new Set(),
        currentArticleImages: new Set(),
    },
    methods: {
        productSearchChange: function () {
            var searchString = $("#search").val();
            if(searchString.length < 4){
                return;
            }
            var url = urlSearch+"?param="+searchString;
            var vm = this;
            axios.get(url).then(function (response) {
                var products = response.data.products;
                var availableTags = [];
                vm.searchMatches = [];
                for (var key in products) {
                    var product = products[key];
                    var match = product.categoryName + " // " + product.collectionName + " // " +product.eanNo + " // " +product.productName;
                    availableTags.push(match);
                    product.selected = false;
                    vm.searchMatches.push(product);
                }
            }).catch(function (error) {
                vm.searchMatches = [];
            });
        },
        selectRow: function (match) {
            match.selected = !match.selected;
            if(match.selected){
                this.selectedProducts.add(match.productId);
                this.updatedArticleImages(match.productId)
            }else{
                this.selectedProducts.delete(match.productId);
                for (let item of this.currentArticleImages.keys()){
                    if(item.productId == match.productId){
                        this.currentArticleImages.delete(item);
                    }
                }
            }
            console.log("selectRow-end", this.currentArticleImages);
        },
        editArticleImage: function () {
            console.log("Edit image", this.selectedProducts);
        },

        updatedArticleImages: function (articleId) {
            var url = urlImages+"?productId="+articleId;
            var vm  = this;
            axios.get(url).then(response => {
                var images = response.data.images;
                for(var key in images){
                    var image = images[key];
                    image.name = "/joka/uploads/"+image.name.replace("\\\\", "/");
                    vm.currentArticleImages.add(image);
                }
            });
        },
        deleteImage: function (articleId, imageId) {
            console.log("deleteImage", articleId, imageId);
        },
        changeImageUsage: function (articleId, imageId, usage) {
            console.log("changeImageUsage", articleId, imageId, usage);
            axios.patch(urlChangeImageUsage,{})
                .then((response) => {
                    console.log("changeImageUsage", response);
                });
        }
    },
    mounted() {
        var vm = this;
        axios.get(urlArticles).then(function (response) {
            vm.articles = response.data.records;
            vm.currentArticles = vm.articles;
        }).catch(function (error) {
            console.log("axios."+urlArticles, error);
        });

        axios.get(urlCategories).then(function (response) {
            vm.categories = response.data.categories;
            vm.treeData = {type: "root", name: 'Alle Kategorien', children: []};

            for (var key in vm.categories) {
                var category = vm.categories[key];
                var url = urlReadCategory + "?category=" + category.id;
                vm.treeData.children.push({type: "category", id: category.id, name: category.name, children: []});
                axios.get(url).then(function (line) {
                    var collections = line.data.collection;
                    var categoryId = collections[0].category;
                    for (var key in vm.treeData.children) {
                        var category = vm.treeData.children[key];
                        if (categoryId == category.id) {
                            for (var key2 in collections) {
                                var collection = collections[key2];
                                category.children.push({
                                    type: "collection",
                                    collectionid: collection.id,
                                    categoryid: category.id,
                                    name: collection.name,
                                    children: []
                                });
                            }
                        }
                    }
                }).catch(function (error) {
                    if (error.status != 404) {
                        console.log("catch.urlReadCategory", error);
                    }
                });
            }
        }).catch(function (error) {
            console.log("axios."+urlCategories, error);
        });
    }

});
