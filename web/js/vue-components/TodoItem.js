import {c} from '/web/js/vue-components/funcs.js';

let temlpate =
`<div class="alert alert-default fade in"
    :class="{'alert-success': task.status, 'alert-danger': task.status == 0}"
>
    <span @click="remove" class="close my-gly glyphicon glyphicon-trash"></span>
    <span @click="rewrite" type="button" class="close my-gly glyphicon glyphicon-pencil"></span>
    <span @click="check" class="close my-gly glyphicon glyphicon-check"></span>
    <b>{{ task.name }}</b>
</div>`;

export let TodoItem = {
    props: {
        task: {type: Object, required: true},
        index: {type: Number, required: true}
    },
    template: temlpate,
    methods: {
        remove: function () {
            this.$emit('remove-task', this.index)
        },
        rewrite: function () {
            let rewritedTask = prompt('Исправте текст задачи', this.task.name)
            if (rewritedTask) {
                this.task.name = rewritedTask
            }
        },
        check: function () {
            this.task.status = !this.task.status;
            this.$emit('sort-tasks')
        }
    },
}