const urlArticles = "/joka/api/product/read.php";
const urlArticle = "/joka/api/product/read_category.php";
const urlCategories = "/joka/api/category/read.php";
const urlLines = "/joka/api/collection/read_category.php";
const urlSearch = "/joka/api/controller/search.php";

new Vue({
    el: '#joka-demo',
    data: {
        searchText: "Hallo Welt",
        articles: [],
        categories: [],
        categoryName: "",
        currentArticles: [],
        currentArticleID: "",
        currentarticle: {},
        treeData: {}
    },
    methods: {
        productSearchChange: function () {
            var searchString = $("#search").val();
            availableTags = ["Parkett", "Laminat"];
            $("#search").autocomplete({source: availableTags});
            console.log("productSearchChange", searchString);
        },
        productSelect: function () {
            var product = $("#search").val();
            console.log("productSelect", product);
        }
    },
    mounted() {
        var vm = this;
        let uri = window.location.search.substring(1);
        let params = new URLSearchParams(uri);

        vm.currentArticleID = params.get("article-id");
        if (vm.currentArticleID != null) {
            axios.get(urlArticle + "?id=" + vm.currentArticleID)
                .then(function (response) {
                    vm.currentarticle = response.data;
                })
                .catch(function (error) {
                    console.log("axios.error", error);
                });
        } else {
            vm.currentArticleID = "";
        }

        axios.get(urlArticles).then(function (response) {
            vm.articles = response.data.records;
            vm.currentArticles = vm.articles;
            // console.log("axios.urlArticles", JSON.stringify(vm.articles));
        }).catch(function (error) {
            console.log("axios.error", error);
        });

        axios.get(urlCategories).then(function (response) {
            vm.categories = response.data.categories;
            vm.treeData = {name: 'Alle Kategorien', children: []};

            for (var key in vm.categories) {
                var category = vm.categories[key];
                var url = urlLines + "?category=" + category.id;
                vm.treeData.children.push({type: "category", id: category.id, name: category.name, children: []});
                axios.get(url).then(function (line) {
                    var collections = line.data.collection;
                    var categoryId = collections[0].category;
                    for (var key in vm.treeData.children) {
                        var category = vm.treeData.children[key];
                        if (categoryId == category.id) {
                            for (var key2 in collections) {
                                var line = collections[key2];
                                category.children.push({
                                    type: "collection",
                                    id: category.id,
                                    name: line.name,
                                    children: []
                                });
                            }
                        }
                    }
                }).catch(function (error) {
                    if (error.status != 404) {
                        console.log("catch.urlLines", error);
                    }
                });
            }
        })
            .catch(function (error) {
                console.log("axios.error", error);
            });
        $( "#search" ).autocomplete({
            source: []
        });
    }
});
