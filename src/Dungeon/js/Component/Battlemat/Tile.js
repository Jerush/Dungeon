Vue.component('battlemat-tile', {
    computed: {
        elements: function () {
            return this.model.filter(
                jQuery.proxy(
                    function (element) {
                        return element.x == this.x && element.y == this.y;
                    },
                    this
                )
            );
        }
    },

    methods: {
        dragend: function (e) {
            jQuery(this.$el).removeClass('drag');
        },

        dragenter: function (e) {
            console.log('dragenter', e.dataTransfer.getData('text/x-dungeon.entity'));
            /*var data = JSON.parse(e.dataTransfer.getData('application/x-dungeon.entity'));
            console.log(data);

            /* var data = JSON.parse(e.dataTransfer.getData('text/plain'));

            if ( ! data.hasOwnProperty('$id') || this.elements.length > 0) {
                return;
            }

            jQuery(this.$el).addClass('drag');

            e.preventDefault();
            e.stopPropagation();
            */
        },

        dragleave: function (e) {
            jQuery(this.$el).removeClass('drag');
        },

        dragover: function (e) {
            if (this.elements.length == 0) {
                e.preventDefault();
                e.stopPropagation();
            }
        },

        drop: function (e) {
            var data = JSON.parse(e.dataTransfer.getData('text/x-dungeon.entity'));

            jQuery.each(this.model, jQuery.proxy(
                function (index, element) {
                    if (element.$id == data.$id) {
                        element.x = this.x;
                        element.y = this.y;
                    }
                },
                this
            ));
        }
    },

    props: {
        model: {
            required: true,
            type: Array
        },
        x: {
            required: true,
            type: Number
        },
        y: {
            required: true,
            type: Number
        }
    },

    template: '#battlemat-tile'
});