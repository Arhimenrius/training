var TrainingList = Backbone.View.extend({
    el: $('.page'),
    render: function(){
        var that = this;
        var trainings = new Trainings();
        trainings.fetch({
            success: function(trainings)
            {
                var template = _.template($("#training_list").html(), {trainings:trainings.models, empty: false} );
                that.$el.html(template);
            },
            error: function()
            {                
                var template = _.template($("#training_list").html(), {trainings:null, empty: true} );
                that.$el.html(template);
            }
        });
    
    },
    events:
    {
        'click .delete': 'deleteTraining',
        'click .view-more': 'viewMore',
        'click .status-change': 'activateTraining'
    },
    deleteTraining: function(ev)
    {
        if(confirm('Are you sure to delete this?'))
        {
            if(confirm('Are you really sure to do this?'))
            {
                var id = $(ev.target).attr('id');
                var training = new Training({id: id});
                training.destroy({
                    success: function()
                    {
                        Backbone.history.loadUrl();
                        return false;
                    }
                });
            }
        }
    },
    viewMore: function(ev)
    {
        var id = $(ev.target).attr('id');
        if(($('tr.'+id)).css('display') == 'none')
        {
            $('tr.'+id).css('display', 'table-row');
        }
        else
        {
            $('tr.'+id).css('display', 'none');
        }
    },
    activateTraining: function(ev)
    {
        var id = $(ev.target).attr('id');
        var active = $(ev.target).data('active');
        
        var data = {id:id, active:!active};
        var training = new Training();
        training.save(data,{
           success: function(response){
                Backbone.history.loadUrl();
                return false;
           } 
        });
    }
});

var TrainingNew = Backbone.View.extend({
    el: $('.page'),
    render: function()
    {
        var that = this;
        var template = _.template($("#training_add_form").html(), {} );
        that.$el.html(template);
    },
    events:
    {
        'submit .add-training': 'addTraining',
    },
    addTraining: function(ev)
    {
        var trainingDetails = $(ev.currentTarget).serializeObject();
        var training = new Training();
        training.save(trainingDetails, {
            success: function(response, id){
                router.navigate("/edit/"+id,  {trigger: true});
            },
            error: function()
            {
                displayError();
            }
        });
        return false;
    }
});

var TrainingEdit = Backbone.View.extend({
    el: $('.page'),
    render: function(options)
    {
        if(options.id > 0)
        {
            var that = this;
            var training = new Training({id:options.id});
            training.fetch({
                success: function(training)
                {
                    var template = _.template($("#training_edit_view").html(), {training:training, error:false} );
                    that.$el.html(template);
                },
                error: function()
                {
                    var template = _.template($("#training_edit_view").html(), {training:training, error:'This training is not exist.'} );
                    that.$el.html(template);
                }
            });
        }
        else
        {
            var template = _.template($("#training_edit_view").html(), {training:training, error:'Training ID cannot be null.'} );
            that.$el.html(template);
        }
    },
    events:
    {
        'submit .edit-training': 'editTraining',
    },
    editTraining: function(ev){
        var trainingDetails = $(ev.currentTarget).serializeObject();
        console.log(trainingDetails);
        var training = new Training();
        training.save(trainingDetails, {
            success: function(response)
            {
                router.navigate("",  {trigger: true});
                return false;
            },
            error: function()
            {
                displayError();
            }
        });
        return false;
    }
});

var trainingList = new TrainingList();
var trainingNew = new TrainingNew();
var trainingEdit = new TrainingEdit();