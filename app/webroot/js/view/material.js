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
        'click .delete-material': 'deleteMaterial'
    },
    deleteMaterial: function(ev)
    {
        if(confirm('Are you sure to delete this?'))
        {
            var id = $(ev.target).attr('id');
            var material = new Material({id: id});
            material.destroy({
                success: function()
                {
                    Backbone.history.loadUrl();
                    return false;
                }
            });
        }
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
               success: function(material){
                    var template = _.template( $("#materials_prepare").html(), {material: material} );
                    that.$el.html(template);
               } 
            });
        }
        else
        {
            var template = _.template($("#materials_prepare").html(), {material: null} );
            that.$el.html(template);
        }
    },
    events:
    {
        'submit .save-material': 'saveMaterial'
    },
    saveMaterial: function(ev)
    {
        var materialDetails = $(ev.currentTarget).serializeObject();
        var material = new Material();
        material.save(materialDetails, {
            success: function(response)
            {
                router.navigate("",  {trigger: true});
            },
            error: function()
            {
                displayError();
            }
        });
        return false;
    }
});

var materialList = new MaterialList();
var materialPrepare = new MaterialPrepare();