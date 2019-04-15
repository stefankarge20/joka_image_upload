const NotFound = { template: '<p>Page not found</p>' }
const Home = { template: '<p>home page</p>' }
const About = { template: '<p>about page</p>' }

Vue.directive('demo', {
    bind: function (el, binding, vnode) {
        var s = JSON.stringify;
        el.innerHTML =
            'name: '       + s(binding.name) + '<br>' +
            'value: '      + s(binding.value) + '<br>' +
            'expression: ' + s(binding.expression) + '<br>' +
            'argument: '   + s(binding.arg) + '<br>' +
            'modifiers: '  + s(binding.modifiers) + '<br>' +
            'vnode keys: ' + Object.keys(vnode).join(', ')
    }
})

new Vue({
    el: '#hook-arguments-example',
    data: {
        message: 'hello!'
    }
})

// define a mixin object
var myMixin = {
    created: function () {
        this.hello()
    },
    methods: {
        hello: function () {
            console.log('hello from mixin!')
        }
    }
}

// define a component that uses this mixin
var Component = Vue.extend({
    mixins: [myMixin]
})

var component = new Component() // => "hello from mixin!"


new Vue({
    el: '#example-3c',
    data: {
        show: true
    }
})

new Vue({
    el: '#example-2b',
    data: {
        show: true
    }
})

new Vue({
    el: '#example-1b',
    data: {
        show: true
    }
})

Vue.component('base-input', {
    inheritAttrs: false,
    props: ['label', 'value'],
    computed: {
        inputListeners: function () {
            var vm = this
            // `Object.assign` merges objects together to form a new object
            return Object.assign({},
                // We add all the listeners from the parent
                this.$listeners,
                // Then we can add custom listeners or override the
                // behavior of some listeners.
                {
                    // This ensures that the component works with v-model
                    input: function (event) {
                        vm.$emit('input', event.target.value)
                    }
                }
            )
        }
    },
    template: `
    <label>
      {{ label }}
      <input
        v-bind="$attrs"
        v-bind:value="value"
        v-on="inputListeners"
      >
    </label>
  `
});


var ComponentB = Vue.component('blog-post', {
    props: ['post'],
    template: `
    <div class="blog-post">
      <h3>{{ post.title }}</h3>
      <button>
        Enlarge text
      </button>
      <div v-html="post.content"></div>
    </div>
  `
});
var ComponentA = Vue.component('custom-input', {
    props: ['value'],
    template: `
    <input
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
    >
  `
});

Vue.component('base-checkbox', {
    model: {
        prop: 'checked',
        event: 'change'
    },
    props: {
        checked: Boolean
    },
    template: `
    <input
      type="checkbox"
      v-bind:checked="checked"
      v-on:change="$emit('change', $event.target.checked)"
    >
  `
});


function Person (firstName, lastName) {
    this.firstName = firstName
    this.lastName = lastName
}

new Vue({
    el: '#blog-posts-events-demo',
    data: {
        posts: [{ id: 1, title: 'Star Trek Enterprise', content: 2151},
            { id: 2, title: 'Star Trek Discovery', content: 2256},
            { id: 3, title: 'Star Trek The Original Series', content: 2267 },
            { id: 4, title: 'Star Trek The next Generation', content: 2375 },
            { id: 5, title: 'Star Trek Deep Space Nine', content:  2378},
            { id: 6, title: 'Star Trek Voyager', content:  2381}],
        postFontSize: 1,
        searchText: "Hallo Welt",
        lovingVue: ''
    }
});




new Vue({
    el: '#blog-post-demo',
    data: {
        posts: [
            { id: 1, title: 'Star Trek Enterprise', content: 2151},
            { id: 2, title: 'Star Trek Discovery', content: 2256},
            { id: 3, title: 'Star Trek The Original Series', content: 2267 },
            { id: 4, title: 'Star Trek The next Generation', content: 2375 },
            { id: 5, title: 'Star Trek Deep Space Nine', content:  2378},
            { id: 6, title: 'Star Trek Voyager', content:  2381}
        ]
    }
});



// Define a new component called button-counter
Vue.component('button-counter', {
    data: function () {
        return {
            count: 0
        }
    },
    template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
});
new Vue({ el: '#components-demo' })

new Vue({
    el: '#example-3b',
    data: {
        checkedNames: [],
        picked: [],
        selected: []
    }
})

new Vue({
    el: '#example-4',
    data: {
        message: 'Vue.js',
        checked: true
    },
    methods: {
        say: function (message) {
            alert(message)
        },

    }
});


new Vue({
    el: '#example-3',
    methods: {
        say: function (message) {
            alert(message)
        },
        warn: function (message, event) {
            // now we have access to the native event
            if (event) event.preventDefault()
            alert(message)
        }
    }
});

var example2a = new Vue({
    el: '#example-2a',
    data: {
        name: 'Vue.js'
    },
    // define methods under the `methods` object
    methods: {
        greet: function (event) {
            // `this` inside methods points to the Vue instance
            alert('Hello ' + this.name + '!')
            // `event` is the native DOM event
            if (event) {
                alert(event.target.tagName)
            }
        }
    }
});

// you can invoke methods in JavaScript too
// example2a.greet() // => 'Hello Vue.js!'

var example1a = new Vue({
    el: '#example-1a',
    data: {
        counter: 0
    }
});

Vue.component('todo-item', {
    template: '\
    <li>\
      {{ title }}\
      <button v-on:click="$emit(\'remove\')">Remove</button>\
    </li>\
  ',
    props: ['title']
});

new Vue({
    el: '#todo-list-example',
    data: {
        newTodoText: '',
        todos: [
            {
                id: 1,
                title: 'Do the dishes',
            },
            {
                id: 2,
                title: 'Take out the trash',
            },
            {
                id: 3,
                title: 'Mow the lawn'
            }
        ],
        nextTodoId: 4
    },
    methods: {
        addNewTodo: function () {
            this.todos.push({
                id: this.nextTodoId++,
                title: this.newTodoText
            }),
            this.newTodoText = ''
        }
    }
});





var vm = new Vue({
    el: '#v-for-object',
    data: {
        object: {
            firstName: 'John',
            lastName: 'Doe',
            age: 30
        },
        userProfile: {
            name: 'Anika'
        },
        numbers: [ 1, 2, 3, 4, 5 ]
    },
    computed: {
        evenNumbers: function () {
            return this.numbers.filter(function (number) {
                return number % 2 === 0
            })
        }
    }
});

Vue.set(vm.userProfile, 'age', 27);


var example2 = new Vue({
    el: '#example-2',
    data: {
        parentMessage: 'Parent',
        items: [
            { message: 'Foo' },
            { message: 'Bar' }
        ]
    }
});


var example1 = new Vue({
    el: '#example-1',
    data: {
        items: [
            { message: 'Foo' },
            { message: 'Bar' }
        ]
    }
});




var watchExampleVM = new Vue({
    el: '#watch-example',
    data: {
        question: '',
        answer: 'I cannot give you an answer until you ask a question!',
        awesome: false
    },
    watch: {
        question: function (newQuestion, oldQuestion) {
            this.answer = 'Waiting for you to stop typing...'
            this.debouncedGetAnswer()
        }
    },
    created: function () {
        this.debouncedGetAnswer = _.debounce(this.getAnswer, 500)
    },
    methods: {
        getAnswer: function () {
            if (this.question.indexOf('?') === -1) {
                this.answer = 'Questions usually contain a question mark. ;-)';
                return;
            }
            this.answer = 'Thinking...';
            var vm = this;
            axios.get('https://yesno.wtf/api')
                .then(function (response) {
                    vm.answer = _.capitalize(response.data.answer);
                })
                .catch(function (error) {
                    vm.answer = 'Error! Could not reach the API. ' + error;
                })
        }
    }
})

var vm2 = new Vue({
    el: '#demo',
    data: {
        firstName: 'Foo',
        lastName: 'Bar'
    },
    computed: {
        fullName: function () {
            return this.firstName + ' ' + this.lastName
        }
    }
});

var vm = new Vue({
    el: '#example',
    data: {
        message: 'Hello'
    },
    computed: {
        // a computed getter
        reversedMessage: function () {
            // `this` points to the vm instance
            return this.message.split('').reverse().join('')
        }
    }
})

var obj = {
    foo: 'bar'
}

Object.freeze(obj);

new Vue({
    el: '#app',
    data: obj,
    created: function () {
        // `this` points to the vm instance
        console.log('a is: ' + this.a)
    }
});


var app = new Vue({
    el: '#app-1',
    data: {
        message: 'Hello Vue!'
    }
});

var app2 = new Vue({
    el: '#app-2',
    data: {
        message: 'You loaded this page on ' + new Date().toLocaleString()
    }
});

var app3 = new Vue({
    el: '#app-3',
    data: {
        seen: true
    }
});

var app4 = new Vue({
    el: '#app-4',
    data: {
        todos: [
            { text: 'Learn JavaScript' },
            { text: 'Learn Vue' },
            { text: 'Build something awesome' }
        ]
    }
});

var app5 = new Vue({
    el: '#app-5',
    data: {
        message: 'Hello Vue.js!',
        date: 'Hello Vue.js! at ' + new Date().toLocaleString()
    },
    methods: {
        reverseMessage: function () {
            this.message = this.message.split('').reverse().join('')
        },
        updateDate: function () {
            this.date =  'Hello Vue.js! at ' + new Date().toLocaleString()
        }
    }
});

var app6 = new Vue({
    el: '#app-6',
    data: {
        message: 'Hello Vue!'
    }
});

Vue.component('todo-item', {
    props: ['todo'],
    template: '<li>{{ todo.text }}</li>'
})

var app7 = new Vue({
    el: '#app-7',
    data: {
        groceryList: [
            { id: 0, text: 'Vegetables' },
            { id: 1, text: 'Cheese' },
            { id: 2, text: 'Whatever else humans are supposed to eat' }
        ]
    }
});

