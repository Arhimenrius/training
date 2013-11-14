var Router = Backbone.Router.extend({
        routes: {
            "": "viewall",  
            "new": "prepare",
            "edit/:id": "prepare"
        }
    });
    // Initiate the router
    var router = new Router;

    router.on('route:viewall', function() {
        professionList.render();
    });
    router.on('route:prepare', function(id) {
        professionForm.render({id: id});
    });

    // Start Backbone history a necessary step for bookmarkable URL's
Backbone.history.start();