import {c} from '/js/vue-components/funcs.js';

let template =
`<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Tasks</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-9">
                <span>Задача:</span>
                <br>
                <input v-model="newTask.name" type="text" class="form-control">
            </div>
            <div class="col-sm-1">
                <span>Часы:</span>
                <br>
                <input v-model="newTask.hours" type="text" class="form-control">
            </div>
            <div class="col-sm-2">
                <br>
                <span class="input-group-btn">
                    <button @click="createTask" class="btn btn-default" type="button">Создать задачу</button>
                </span>
            </div>
        </div>
    </div>
</div>`

export let TaskCreator = {
    data: function () {
        return {
            newTask: {name: '', hours: 1, status: false}
        }
    },
    template: template,
    methods: {
        createTask: function () {
            if (this.newTask.name.trim()) {
                this.$emit('create-task', {
                    name: this.newTask.name,
                    hours: this.newTask.hours,
                    status: 0
                })
                this.newTask.name = ''
            }
        }
    }
}