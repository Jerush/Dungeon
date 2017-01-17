Vue.component('battlemat-item', {
    methods: {
        dragstart: function (e) {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/x-dungeon.entity', JSON.stringify(this.element));
        }
    },

    props: {
        element: {
            required: true,
            type: Object
        }
    },

    template: '#battlemat-item'
});