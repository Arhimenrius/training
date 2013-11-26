var Router = Backbone.Router.extend({
    routes:{
        "" : "viewall",
        "record/:id" : "record",
        "payment/:id" : "payment",
        "cancel/:id" : "cancel",
        "success/:id" : "success"
    }
});

var router = new Router();

router.on('route:viewall', function(){
    recordList.render();
});
router.on('route:record', function(id){
    recordForm.render({id:id});
});
router.on('route:payment', function(id){
    recordPayment.render({id:id});
});
router.on('route:cancel', function(id){
    recordCancel.render({id:id});
});
router.on('route:success', function(id){
    recordSuccess.render({id:id});
});

Backbone.history.start();