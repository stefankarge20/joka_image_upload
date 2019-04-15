<div class="col-1" style="background: aliceblue">
    <h3>Kategorien</h3>
    <ul class="list-group">
        <li lass="list-group-item" v-for="(category, index) in categories">
            <button type="button" class="btn btn-success" v-on:click="updateProductList(category.name)">{{ category.name }}</button>
        </li>
    </ul>
    <ul class="list-group">
        <li lass="list-group-item" v-for="(category, index) in categories">
            <a v-bind:href="'/joka/view/index.php?category='+ category.name">{{ category.name }}</a>
        </li>
    </ul>
</div>

