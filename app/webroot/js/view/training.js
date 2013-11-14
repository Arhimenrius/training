var TrainingList = Backbone.View.extend({
    el: $('.page'),
    render: function(){
        var that = this;
        var trainings = new Trainings();
        trainings.fetch({
            success: function(trainings)
            {
                var template = _.template($("#training_list").html(), {trainings:trainings.models} );
                that.$el.html(template);
            }
        });
    
    },
    events:
    {

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

    }
});

var TrainingEdit = Backbone.View.extend({
    el: $('.page'),
    render: function()
    {
        var that = this;
        var template = _.template($("#training_edit_view").html(), {} );
        that.$el.html(template);
    },
    events:
    {

    }
});

var trainingList = new TrainingList();
var trainingNew = new TrainingNew();
var trainingEdit = new TrainingEdit();