Vue.component('battlemat', {
    props: {
        elements: {
            required: true,
            type: Array
        },
    },

    template: '#battlemat'
});