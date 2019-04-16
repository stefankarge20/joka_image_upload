const urlArticles = "/joka/api/product/read.php";
const urlCategories = "/joka/api/category/read.php";
const urlReadCategory = "/joka/api/collection/read_category.php";
const urlCollectionArticles = "/joka/api/product/read_collections.php";
const urlSearch = "/joka/api/controller/search.php";

$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
            $('.image-preview').popover('show');
        },
        function () {
            $('.image-preview').popover('hide');
        }
    );
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
});

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
        treeData: {},
        searchMatches: [],
        selectedProducts: new Set()
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
            }else{
                this.selectedProducts.delete(match.productId);
            }
        },
        editArticleImage: function () {
            console.log("Edit image", this.selectedProducts);
        },
    },
    mounted() {
        var vm = this;
        axios.get(urlArticles).then(function (response) {
            vm.articles = response.data.records;
            vm.currentArticles = vm.articles;
            // console.log("axios.urlArticles", JSON.stringify(vm.articles));
        }).catch(function (error) {
            console.log("axios.error", error);
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
            console.log("axios.error", error);
        });


        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    }

});
