let tree = Vue.component('tree-item', {
    template: ' <li>' +
        '            <div v-bind:class="{bold: isFolder}" @click="update">' +
        '                <span v-if="isRoot || isCollection">{{ item.name }}</span>' +
        '                <span v-if="isCategory" @click="addProductToCollection">{{ item.name }}</span>' +
        '                <span v-if="isProduct" @click="selectItem"><input type="checkbox" v-model="item.selected"> {{ item.name }}</span>' +
        '                <span v-if="isFolder" >[{{ isOpen ? \'-\' : \'+\' }}]</span>' +
        '            </div>' +
        '            <ul v-show="isOpen" v-if="isFolder">' +
        '                <tree-item' +
        '                        class="item"' +
        '                        v-for="(child, index) in item.children"' +
        '                        :key="index"' +
        '                        :item="child"' +
        '                        :selectedproducts="selectedproducts"' +
        '                ></tree-item>' +
        '            </ul>' +
        '        </li>',

    props: ['item', 'selectedproducts'],
    data: function () {
        return {
            isOpen: false
        }
    },
    computed: {
        isFolder: function () {
            var folder = this.item.children && this.item.children.length;
            return folder > 0;
        },
        isCategory: function () {
            return this.item.type == "category";
        },
        isRoot: function () {
            return this.item.type == "root";
        },
        isCollection: function () {
            return this.item.type == "collection";
        },
        isProduct: function () {
            return this.item.type == "product";
        }
    },
    methods: {
        update: function () {
            if (this.isFolder) {
                this.isOpen = !this.isOpen
            }
        },
        selectItem: function () {
            this.item.selected = !this.item.selected;
            if(this.item.selected){
                this.selectedproducts.add(this.item.productId);
            }else{
                this.selectedproducts.delete(this.item.productId);
            }

        },
        addProductToCollection: function () {
            if(this.isOpen){
                return;
            }
            for(let key in this.item.children){
                let cmp = this;
                cmp.child = this.item.children[key];
                if (typeof cmp.child.categoryid === 'undefined') {
                    continue;
                }

                var url = urlCollectionArticles+"?category="+cmp.child.categoryid+"&collection="+cmp.child.collectionid;
                axios.get(url).then(function (response) {
                    var products = response.data.products;
                    for(var key2 in products){
                        var product = products[key2];
                        var contains = cmp.contains(cmp.child.children, product);
                        if(!contains){
                            cmp.child.children.push({type: "product", selected: false, productId: product.id, name: product.name, children: []});
                        }
                    }
                }).catch(function (error) {
                    if(error.status != 404) {
                        console.error("addProductToCollection.error", error);
                    }
                });
            }
        },
        contains: function (articles, article) {
            var found = false;
            for(var i = 0; i < articles.length; i++) {
                if (articles[i].productId == article.id) {
                    found = true;
                    break;
                }
            }
            return found;
        }
    }
});

