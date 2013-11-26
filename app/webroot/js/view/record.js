var RecordList = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        var trainings = new Trainings();
        trainings.fetch({
            success: function(trainings)
            {
                var template = _.template($("#record-list").html(), {trainings:trainings.models, empty: false} );
                that.$el.html(template);
            },
            error: function()
            {                
                var template = _.template($("#record-list").html(), {trainings:null, empty: true} );
                that.$el.html(template);
            }
        });
    },
    events:
    {
        'click .view-more': 'viewMore',
        'click .record': 'record'
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
        return false;
    },
    record: function(ev)
    {
        var id = $(ev.target).attr('id');
        router.navigate("record/"+id,  {trigger: true});
        
        return false;
    }
});

var RecordForm = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
            var training = new Training({id:options.id});
            training.fetch({
                success: function(training)
                {
                    if(training.get('active') == false)
                    {
                        router.navigate("", {trigger: true});
                    }
                    else
                    {
                        var template = _.template($("#record-form").html(), {training:training} );
                        that.$el.html(template);
                    }
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
        'click .view-more-info': 'viewMoreInfo',
        'click .view-more-participants': 'viewMoreParticipants',
        'click .view-more-materials': 'viewMoreMaterials',
        'click .add-student': 'addStudent',
        'click .add-child': 'addChild',
        'submit .save-record': 'saveRecord'
    },
    viewMoreInfo: function(ev)
    {
        var id = $(ev.target).attr('id');
        if(($('table.'+id)).css('display') == 'none')
        {
            $('table.'+id).css('display', 'table-row-group');
            $('#info').text('Hide informations');
        }
        else
        {
            $('table.'+id).css('display', 'none');
            $('#info').text('Show informations');
        }
        return false;
    },
    viewMoreParticipants: function(ev)
    {
        var id = $(ev.target).attr('id');
        if(($('div.'+id)).css('display') == 'none')
        {
            $('div.'+id).css('display', 'block');
            $('#participants').text('Hide participants');
        }
        else
        {
            $('div.'+id).css('display', 'none');
            $('#participants').text('Show participants');
        }
        return false;
    },
    viewMoreMaterials: function(ev)
    {
        var id = $(ev.target).attr('id');
        if(($('table.'+id)).css('display') == 'none')
        {
            $('table.'+id).css('display', 'table-row-group');
            $('#material').text('Hide materials');
        }
        else
        {
            $('table.'+id).css('display', 'none');
            $('#material').text('Show materials');
        }
        return false;
    },
    saveRecord: function(ev)
    {
        validmaterial();
        if(validpriority() != false)
        {
            var recordDetails = $(ev.currentTarget).serializeObject();
            var record = new Record();
            record.save(recordDetails, {
                success: function(response, id)
                {
                    router.navigate("#payment/"+id,  {trigger: true});
                },
                error: function(response, error)
                {
                    displayError(error.responseText);
                }
            });
        }
        
        
        return false;
    },
    addStudent: function(ev)
    {
        $('.student-forms').append('<div class="student-form"><h4 class="student-info">Student</h4><div class="student-input-block"><div class="student-label"><label>Name</label></div><div class="student-input"><input type="text" name="student_name" maxLength="150" required class="form-control name"></div></div><div class="student-input-block"><div class="student-label"><label>Surname</label></div><div class="student-input"><input type="text" name="student_surname" required maxLength="150" class="form-control surname"></div></div></div>');
        $('div.participants').css('display', 'block');
        $('#participants').text('Hide participants');
        return false;
    },
    addChild: function(ev)
    { 
        $('.student-forms').append('<div class="student-form"><h4 class="child-info">Child</h4><div class="student-input-block"><div class="student-label"><label>Name</label></div><div class="student-input"><input type="text" name="child_name" required class="form-control name"></div></div><div class="student-input-block"><div class="student-label"><label>Surname</label></div><div class="student-input"><input type="text" name="child_surname" required class="form-control surname"></div></div><div class="student-input-block"><div class="student-label"><label>Age</label></div><div class="student-input"><input type="text" name="child_age" required class="form-control age"></div></div></div>');
        $('div.participants').css('display', 'block');
        $('#participants').text('Hide participants');
        return false;
    }
});

var RecordPayment = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
            var record = new Record({id:options.id});
            record.fetch({
                success: function(record)
                {
                    if(record.get('Payment').payment_status == 'Processing')
                    {
                        var template = _.template($("#record-payment").html(), {record:record, id:options.id} );
                        that.$el.html(template);
                    }
                    else
                    {
                        router.navigate("", {trigger: true});
                    }
                    
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

    }
});
var RecordCancel = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
           var record = new Record({id:options.id});
            record.fetch({
                success: function(record)
                {
                    if(record.get('Payment').payment_status == 'Processing')
                    {
                        var payment = new Payment({id:record.get('Payment').id, payment_status:'Cancel'});
                        payment.save({
                            success: function(response)
                            {
                               
                            }
                        });
                        var template = _.template($("#record-cancel").html(), {} );
                        that.$el.html(template);
                        
                    }
                    else
                    {
                        router.navigate("", {trigger: true});
                    }
                    
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
        'click .return' : 'returnToHomepage'
    },
    returnToHomepage: function()
    {
        router.navigate("", {trigger: true});
    }
});
var RecordSuccess = Backbone.View.extend({
    el: $('.page'),
    render: function(options){
        var that = this;
        if(options.id)
        {
           var record = new Record({id:options.id});
            record.fetch({
                success: function(record)
                {
                    if(record.get('Payment').payment_status == 'Processing')
                    {
                        var payment = new Payment({id:record.get('Payment').id, payment_status:'Success'});
                        payment.save({
                            success: function(response)
                            {
                               
                            }
                        });
                        var template = _.template($("#record-success").html(), {} );
                        that.$el.html(template);
                        
                    }
                    else
                    {
                        router.navigate("", {trigger: true});
                    }
                    
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
        'click .return' : 'returnToHomepage'
    },
    returnToHomepage: function()
    {
        router.navigate("", {trigger: true});
    }
});

var recordList = new RecordList();
var recordForm = new RecordForm();
var recordPayment = new RecordPayment();
var recordCancel = new RecordCancel();
var recordSuccess = new RecordSuccess();