Vue.component('tree-item', {
    template: ' <li>' +
        '            <div' +
        '                    :class="{bold: isFolder}" @click="update">' +
        '                <a v-if="isCollection" href="#">{{ item.name }}</a>' +
        '                <span v-else>{{ item.name }}</span>' +
        '                <span v-if="isFolder">[{{ isOpen ? \'-\' : \'+\' }}]</span>' +
        '            </div>' +
        '            <ul v-show="isOpen" v-if="isFolder">' +
        '                <tree-item' +
        '                        class="item"' +
        '                        v-for="(child, index) in item.children"' +
        '                        :key="index"' +
        '                        :item="child"' +
        '                ></tree-item>' +
        '            </ul>' +
        '        </li>',

    props: ['item'],
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
        isCollection: function () {
            return this.item.type == "collection"
        }
    },
    methods: {
        update: function () {
            if (this.isFolder) {
                this.isOpen = !this.isOpen
            }
            if(this.item.type == "collection"){
                console.log(this.item.type, this.item.name);
            }
        }
    }
});

