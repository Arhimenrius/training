var PaymentList = Backbone.View.extend({
    el: $('.page'),
    render: function(){
        var records = new Records();
        var that = this;
        records.fetch({
            success: function(records){
                var template = _.template($("#payments-list").html(), {records: records.models, empty:false} );
                that.$el.html(template);
           },
            error: function(){
                var template = _.template($("#payments-list").html(), {records: null, empty:true} );
                that.$el.html(template);
            }
        })
    },
});
var PaymentDetails = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
            var record = new Record({id:options.id});
            record.fetch({ 
                data:{logs:true},
                success: function(record){
                    var template = _.template( $("#payment-details").html(), {record: record} );
                    that.$el.html(template);
                },
                error: function(record){
                    router.navigate("", {trigger: true});
                }
            });
        }
        else
        {
            router.navigate("", {trigger: true});
        }
    },
    events:
    {
        'click button.activities': 'activitiesAction',
        'click button.materials': 'materialsAction',
        'click button.students': 'studentsAction',
        'click button.childs': 'childsAction',
        'click button.main': 'mainAction',
    },
    activitiesAction: function(ev)
    {
        if($('table.activities').css('display') == 'none')
        {
            $('table.activities').css('display', 'table');
        }
        else
        {
            $('table.activities').css('display', 'none');
        }
    },
    materialsAction: function(ev)
    {
        if($('table.materials').css('display') == 'none')
        {
            $('table.materials').css('display', 'table');
        }
        else
        {
            $('table.materials').css('display', 'none');
        }
    },
    studentsAction: function(ev)
    {
        if($('table.students').css('display') == 'none')
        {
            $('table.students').css('display', 'table');
        }
        else
        {
            $('table.students').css('display', 'none');
        }
    },
    childsAction: function(ev)
    {
        if($('table.childs').css('display') == 'none')
        {
            $('table.childs').css('display', 'table');
        }
        else
        {
            $('table.childs').css('display', 'none');
        }
    },
    mainAction: function(ev)
    {
        if($('table.main').css('display') == 'none')
        {
            $('table.main').css('display', 'table');
        }
        else
        {
            $('table.main').css('display', 'none');
        }
    }
});

var paymentList = new PaymentList();
var paymentDetails = new PaymentDetails();