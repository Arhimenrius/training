var ProfessionForm = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
            var profession = new Profession({id:options.id});
            profession.fetch({
               success: function(profession){
                    var template = _.template( $("#profession_form").html(), {profession: profession} );
                    that.$el.html(template);
               } 
            });
        }
        else
        {
        var template = _.template( $("#profession_form").html(), {profession:null} );
        that.$el.html(template);
        
        }
    },
    events: {
        'submit .prepare-profession': 'saveProfession',
    },
    saveProfession: function(ev){
        var professionDetails = $(ev.currentTarget).serializeObject();
        var profession = new Profession();
        profession.save(professionDetails, {
            success: function (response) {
                router.navigate("",  {trigger: true});
            }
        });
        return false;
    }
           
});


var ProfessionList = Backbone.View.extend({
    el: $('.page'),
    render: function(){
        var that = this;
        var professions = new Professions();
        professions.fetch({
            success: function(professions){
                var template = _.template($("#profession_list").html(), {professions: professions.models, empty: false} );
                that.$el.html(template);
            },
            error: function(){
                var template = _.template($("#profession_list").html(), {professions: null, empty: true} );
                that.$el.html(template);
            }
        });
    
    },
    events: {
        'click .btn-danger': 'deleteProfession',
    },
    deleteProfession: function(ev)
    {
        if(confirm('Are you sure to delete this?'))
        {
            var id = $(ev.target).attr('id');
            var profession = new Profession({id: id});
            profession.destroy({
                success: function()
                {
                    Backbone.history.loadUrl();
                    return false;
                }
            });
        }
    }
});


var professionForm = new ProfessionForm();
var professionList = new ProfessionList();