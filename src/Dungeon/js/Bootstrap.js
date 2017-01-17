new Vue({
    el: '#application',

    created: function () {
        jQuery.ajaxSetup({
            complete: function () {
                this.loading = false;
            }
        });
    },

    router: new VueRouter({
        linkActiveClass: 'active',
        routes: [
            {
                path: '/battlemat',
                name: 'battlemat',

                components: {
                    root: {
                        data: function () {
                            return {
                                loading: false,
                                characters: []
                            }
                        },

                        created: function () {
                            this.fetch();
                        },

                        methods: {
                            getCharacter: function (x, y) {

                            },

                            fetch: function (to, from) {
                                this.loading = true;

                                jQuery
                                    .ajax('/api/characters', {
                                        context: this,
                                        method: 'POST'
                                    })
                                    .then(
                                        function (response) {
                                            this.characters = response.results;
                                        }
                                    );
                            }
                        },

                        template: '#route-battlemat',

                        watch: {
                            $route: 'fetch'
                        }
                    }
                }
            },

            {
                path: '/characters',
                name: 'characters',

                components: {
                    root: {
                        data: function () {
                            return {
                                loading: false,
                                characters: []
                            }
                        },

                        created: function () {
                            this.fetch();
                        },

                        methods: {
                            fetch: function (to, from) {
                                this.loading = true;

                                jQuery
                                    .ajax('/api/characters', {
                                        context: this,
                                        method: 'POST'
                                    })
                                    .then(
                                        function (response) {
                                            this.characters = response.results;
                                        }
                                    );
                            }
                        },

                        template: '#route-characters',

                        watch: {
                            $route: 'fetch'
                        }
                    }
                },

                children: [
                    {
                        path: ':character',
                        name: 'characters.item',

                        components: {
                            root: {
                                data: function () {
                                    return {
                                        loading: false,
                                        character: {}
                                    }
                                },

                                template: '#route-characters-item'
                            }
                        }
                    }
                ]
            }
        ]
    })
});