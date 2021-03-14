import {c} from '/web/js/vue-components/funcs.js';

let template =
`<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Tasks</h3>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="input-group">
                <input v-model="newTask" type="text" class="form-control">
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
            newTask: ''
        }
    },
    template: template,
    methods: {
        createTask: function () {
            if (this.newTask.trim()) {
                this.$emit('create-task', {name: this.newTask, status: false})
                this.newTask = ''
            }
        }
    }
}