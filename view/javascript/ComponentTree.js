Vue.component('tree-item', {
    template: ' <li>' +
        '            <div v-bind:class="{bold: isFolder}" @click="update">' +
        '                <span v-if="isRootOrCategory">{{ item.name }}</span>' +
        '                <span v-if="isCollection" @click="addProductToCollection">{{ item.name }}</span>' +
        '                <span v-if="isProduct" @click="selectItem"><input type="checkbox" v-if="isProduct" v-model="item.selected"> {{ item.name }}</span>' +
        '                <span v-if="isFolder">[{{ isOpen ? \'-\' : \'+\' }}]</span>' +
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
        isRootOrCategory: function () {
            return this.item.type == "root" || this.item.type == "category";
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
            if(this.item.children.length > 0){
                return;
            }
            var url = urlCollectionArticles+"?category="+this.item.categoryid+"&collection="+this.item.collectionid;
            var cmp = this;

            axios.get(url).then(function (response) {
                var products = response.data.products;
                for(var key in products){
                    var product = products[key];
                    cmp.item.children.push({type: "product", selected: false, productId: product.id, name: product.name, children: []});
                }
            }).catch(function (error) {
            });
        }
    }
});

