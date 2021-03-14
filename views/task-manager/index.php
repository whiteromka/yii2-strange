<?php

use yii\web\View;

/** @var View $this */
?>
<div class="container">
    <div id="vue-main">

        <task-creator @create-task="createTask"></task-creator>

        <div class="row">
            <div class="col-sm-12" >
                <todo-item
                    v-for="(task, i) in tasks"
                    :task="task"
                    :index="i"
                    @remove-task="removeTask"
                    @sort-tasks="sortTasks"
                >
                </todo-item>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.esm.browser.js';
    import {TodoItem} from '/web/js/vue-components/TodoItem.js';
    import {TaskCreator} from '/web/js/vue-components/TaskCreator.js';
    import {c} from '/web/js/vue-components/funcs.js';

    var app = new Vue({
        el: '#vue-main',
        components: {
            'todo-item': TodoItem,
            'task-creator': TaskCreator
        },
        data: {
            newTask:'',
            tasks: []
        },
        methods: {
            createTask: function (task) {
                this.tasks.unshift(task);
            },
            removeTask: function (index) {
                this.tasks.splice(index, 1);
            },
            sortTasks: function () {
               this.tasks.sort(function(a, b) {
                    if (a.status < b.status) return -1;
                    if (a.status > b.status) return 1;
                })
            }
        },
        mounted: function () {
            fetch('/ajax/get-tasks')
                .then((response) => {
                   return response.json();
                }).then((data) => {
                    this.tasks = data
                })
        }
    })
</script>