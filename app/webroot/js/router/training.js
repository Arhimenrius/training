var Router = Backbone.Router.extend({
    routes:{
        "" : "viewall",
        "new" : "new",
        "edit/:id" : "edit"
    }
});

var router = new Router();

router.on('route:viewall', function(){
    trainingList.render();
});
router.on('route:new', function(){
    trainingNew.render();
});
router.on('route:edit', function(id){
    trainingEdit.render({id:id});
});

Backbone.history.start();