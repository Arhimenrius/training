var Router = Backbone.Router.extend({
    routes:{
        "" : "viewall",
        "new" : "prepare",
        "edit/:id" : "prepare"
    }
});

var router = new Router();

router.on('route:viewall', function(){
    materialList.render();
});
router.on('route:prepare', function(id){
    materialPrepare.render({id:id});
});

Backbone.history.start();