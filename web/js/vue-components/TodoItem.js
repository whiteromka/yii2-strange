import {c} from '/web/js/vue-components/funcs.js';

let temlpate =
`
<li class="">    
    <span class="handle ui-sortable-handle">
        <i class="fa fa-ellipsis-v"></i>
        <i class="fa fa-ellipsis-v"></i>
    </span>
    <span @click="check" class="p-2 b-r-2 fa fa-check"
        :class="{'alert-success': task.status == 1, 'alert-default': task.status == 0}"
    ></span>
    <span class="text"><b>{{ task.name }}</b></span>
    <span @click="reTime" class="label label-default">
        <i class="fa fa-clock-o f-s-13" > &#160; <b class="f-s-13">{{ task.hours }} </b> </i> 
    </span>
    <div class="tools">
        <i @click="check" class="c-g fa fa-check-square-o f-s-18" ></i>
        <i @click="reName" class="c-g fa fa-edit f-s-18"></i>
        <i @click="remove(task)" class="fa fa-trash-o f-s-18"></i>
    </div>
</li>
`;

export let TodoItem = {
    props: {
        task: {type: Object, required: true},
        remove: {type: Function, required: true},
        createParams: {type: Function, required: true}
    },
    template: temlpate,
    methods: {
        reName: function () {
            let newName = prompt('Исправте текст задачи', this.task.name)
            if (newName)  {
                this.task.name = newName
                this.saveTask(this.task)
            }
        },
        reTime: function () {
            let newHours = prompt('Исправте время задачи', this.task.hours)
            if (newHours)  {
                this.task.hours = newHours
                this.saveTask(this.task);
            }
        },
        check: function () {
            this.task.status = (this.task.status == 1) ? 0 : 1;
            this.saveTask(this.task);
            this.$emit('sort-tasks')
        },
        saveTask: function (task) {
            let params = this.createParams(task)
            let config = {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
            axios.post('change', params, config)
                .then(res => {
                    if (res.data.error) c('Что то пошло не так... ' + data.data.error)
                });
        },
    },
}