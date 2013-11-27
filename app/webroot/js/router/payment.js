var Router = Backbone.Router.extend({
        routes: {
            "": "viewall",  
            "details/:id": "details",
        }
    });
    // Initiate the router
    var router = new Router;

    router.on('route:viewall', function() {
        paymentList.render();
    });
    router.on('route:details', function(id) {
        paymentDetails.render({id: id});
    });

    // Start Backbone history a necessary step for bookmarkable URL's
Backbone.history.start();