var MaterialList = Backbone.View.extend({
    el: $('.page'),
    render: function(){
        var materials = new Materials();
        var that = this;
        materials.fetch({
            success: function(materials){
                var template = _.template($("#materials_list").html(), {materials: materials.models, empty: false} );
                that.$el.html(template);
            },
            error: function(){
                var template = _.template($("#materials_list").html(), {materials: null, empty: true} );
                that.$el.html(template);
            }
        })
    },
    events:
    {

    }
});
var MaterialPrepare = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
            var material = new Material({id:options.id});
            material.fetch({
               success: function(response)
               {
                   var template = _.template($("#materials_prepare").html(), {materials: material} );
                    that.$el.html(template);
               },
            });
        }
        else
        {
            var template = _.template($("#materials_prepare").html(), {materials: null} );
            that.$el.html(template);
        }
    },
    events:
    {

    }
});

var materialList = new MaterialList();
var materialPrepare = new MaterialPrepare();