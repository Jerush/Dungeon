Vue.component('character-inventory', {
    template: '#character-inventory',
    watch: {
        $route: function (to, from) {
            //console.log(to, from);
        }
    }
});