<?php

use yii\web\View;

/** @var View $this */
?>


<div class="container-fluid">
    <div id="vue-main">

        <task-creator @create-task="createTask"></task-creator>

        <div class="row">
            <div class="box-body">
                <ul class="todo-list ui-sortable">
                    <todo-item
                            v-for="(task, i) in tasks" :key="task.id"
                            :task="task"
                            :remove="removeTask"
                            :create-params="createParams"
                            @sort-tasks="sortTasks"
                    >
                    </todo-item>
                </ul>
            </div>

        </div>
    </div>
</div>

<script type="module">
    import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.esm.browser.js';
    import {TodoItem} from '/js/vue-components/TodoItem.js';
    import {TaskCreator} from '/js/vue-components/TaskCreator.js';
    import {c} from '/js/vue-components/funcs.js';

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    var app = new Vue({
        el: '#vue-main',
        components: {
            'todo-item': TodoItem,
            'task-creator': TaskCreator
        },
        data: {
            tasks: []
        },
        methods: {
            createTask: function (task) {
                let params = this.createParams(task)
                let config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
                axios.post('create', params, config)
                    .then(res => {
                        if (res.data.error) {
                            c('Что то пошло не так... ' + data.data.error)
                        } else {
                            task.id = res.data.id
                            this.tasks.unshift(task)
                        }
                    });
            },
            removeTask: function (task) {
                for (let i = 0; i < this.tasks.length; i++) {
                    let currentTask = this.tasks[i]
                    if (currentTask.id == task.id) {
                        axios.get('delete?id='+task.id).then(res => {
                            if (res.data.success) {
                                this.tasks.splice(i, 1);
                            }
                        })
                        break
                    }
                }
            },
            sortTasks: function () {
               this.tasks.sort(function(a, b) {
                    if (a.status < b.status) return -1;
                    if (a.status > b.status) return 1;
                })
            },
            createParams: function (task) {
                let params = new URLSearchParams()
                if (task.id) params.append('id', task.id)
                params.append('name', task.name)
                params.append('hours', task.hours)
                params.append('status', task.status)
                return params
            }
        },
        mounted: function () {
            fetch('/task/get-tasks')
                .then((response) => {
                   return response.json();
                }).then((data) => {
                    this.tasks = data
                })
        }
    })
</script>