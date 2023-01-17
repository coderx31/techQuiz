const QuestionRouter = Backbone.Router.extend({
    routes: {
        "": "allQuestionsView",
        "question/:question_id": "questionView",
        "askquestion": "askQuestionView",
        "editquestion/:question_id": "editQuestionView"
    },
    allQuestionsView: allQuestionsView,
    questionView: questionView,
    askQuestionView: askQuestionView,
    editQuestionView: editQuestionView
});


// allQuestionsView function
function allQuestionsView() {
    // create the model
    const Question = Backbone.Model.extend();

    // create the collection
    const Questions = Backbone.Collection.extend({
        model: Question,
        url: 'http://localhost/techQuiz/questions/get',
        parse: function(data) {
            return data.result;
        }
    });

    // fetch all questions into collection
    const allQuestions = new Questions();
    allQuestions.fetch({
        async: false,
        success: function(collection,response, options) {
            // TODO need to refactor this code snipet
            console.log('success');
            console.log(`collection - ${JSON.stringify(collection)}`);
            console.log(`response - ${JSON.stringify(response)}`); // this is the http response
            console.log(`options - ${JSON.stringify(options)}`);
        },
        error: function(colection, response, options) {
            console.log('error');
            
        }
    });

    // print for loggin purposes
    console.log(allQuestions.toJSON());

    const QuestionsView = Backbone.View.extend({
        el: '#content',
        template: _.template($('#questions-template').html()),
        events: {
            "click #upvote": "upVote",
            "click #downvote": "downVote"
        },
        collection: allQuestions,
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('questions running');
            console.log(this.collection.toJSON());

            console.log(localStorage.getItem('token'));
    
            this.$el.html(this.template({
                questions: this.collection.toJSON()
            }));
        },
        upVote: function() {
            console.log('upvote icon pressed');
        },
        downVote: function() {
            console.log('downvote icon pressed');
        }
    });

    // create the view
    const questionsView = new QuestionsView();

}

// questionView function
function questionView(question_id) {
    // create the model
    const Question = Backbone.Model.extend({
        url: `http://localhost/techQuiz/questions/get?question_id=${question_id}`,
        parse: function(response, options) {
            return response.result;
        }
    });

    const question = new Question();

    question.fetch({
        async: false,
        success: function(model, response, options) {
            console.log(response);
        },
        error: function(model, reponse, options) {
            console.log('error');
        }
    })

    console.log(question.toJSON());

    const QuestionView = Backbone.View.extend({
        el: '#content',
        template: _.template($('#question-template').html()),
        model: question,
        events: {
            'submit': 'addAnswer',
            'click #upvote': 'upVote',
            'click #downvote': 'downVote',
            'click #deleteQuestion': 'deleteQuestion'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log(this.model.toJSON());
            console.log('question view running');
            this.$el.html(this.template({
                question: this.model.toJSON()
            }))
        },
        addAnswer: function(e) {
            e.preventDefault();

            const Answer = Backbone.Model.extend();

            const answer = new Answer();
            console.log('print the question model');
            console.log(question.toJSON());

            answer.set({
                question_id: $('#question_id').val(),
                body: $('#answer_body').val()
            });

            console.log(answer.toJSON());

            answer.save(
                {},
                {
                    url: 'http://localhost/techQuiz/answers/create',
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.reload(true);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                }
            )

        },
        upVote: _.once(function() {
            console.log('upvote clicked');
            if(localStorage.getItem('token')) {
                $.ajax({
                    url: `http://localhost/techQuiz/questions/upvote/${question_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        console.log(response);
                        window.location.reload(true);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            } else {
                window.location.href = 'http://localhost/techQuiz/users/login';
            }
        }),
        downVote: _.once(function() {
            console.log('downvote clicked');
            if (localStorage.getItem('token')) {
                $.ajax({
                    url: `http://localhost/techQuiz/questions/downvote/${question_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        console.log(response);
                        window.location.reload(true);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            } else {
                window.location.href = 'http://localhost/techQuiz/users/login';
            }
        }),
        deleteQuestion: function() {
            if(localStorage.getItem('token')) {
               $.ajax({
                url: `http://localhost/techQuiz/questions/delete/${question_id}`,
                headers: {
                    'Content-Type': 'application/json',
                    'x-auth': localStorage.getItem('token')
                },
                type: 'DELETE',
                success: function(response) {
                    console.log(response);
                    window.location.href = 'http://localhost/techQuiz/questions/';
                },
                error: function(response) {
                    console.log(response);
                }
               })
            } else {
                window.location.href = 'http://localhost/techQuiz/users/login';
            }
        }
    });

    const questionView = new QuestionView();
} 

// askQuestionView function

function askQuestionView() {
    const Question = Backbone.Model.extend();

    const question = new Question();

    const AskQuestion = Backbone.View.extend({
        el: '#content',
        template: _.template($('#ask-question').html()),
        model: question,
        events: {
            "submit": 'askQuestion'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('ask question view running');
            this.$el.html(this.template())
        },
        askQuestion: function(e) {
            e.preventDefault();
            this.model.set({
                title: $('#title').val(),
                body: $('#body').val()
            });

            console.log(this.model.toJSON());

            this.model.save(
                {},
                {
                    url: 'http://localhost/techQuiz/questions/create',
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        console.log(response);
                        //TODO clear the question form
                        window.location.href='http://localhost/techQuiz/questions';
                    },
                    error: function(response) {
                        console.log(response);
                    }
                }
            )
        }
    });

    const askQuestion = new AskQuestion();

}

// edit question view
function editQuestionView(question_id) {
    // const Question = Backbone.Model.extend();

    const Question = Backbone.Model.extend({
        url: `http://localhost/techQuiz/questions/get?question_id=${question_id}`,
        isNew: function(){
            return false;
        },
        parse: function(response, options) {
            return response.result;
        }
    });

    const question = new Question();

    question.fetch({
        async: false,
        success: function(model, response, options) {
            console.log('success');
            console.log(`model - ${JSON.stringify(model)}`);
            console.log(`response - ${JSON.stringify(response)}`);
            console.log(`options - ${JSON.stringify(options)}`);
        },
        error: function(model, reponse, options) {
            console.log(response);
        }
    })

    const EditQuestion = Backbone.View.extend({
        el: '#content',
        template: _.template($('#edit-question').html()),
        model: question,
        events: {
            "submit": 'editQuestion'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('edit question view running');
            this.$el.html(this.template({
                question: this.model.toJSON()
            }))
        },
        editQuestion: function(e) {
            e.preventDefault();

            this.model.clear();

            this.model.set({
                title: $('#title').val(),
                body: $('#body').val()
            });

            console.log(this.model.toJSON());

            this.model.save(
                {},
                {
                    url: `http://localhost/techQuiz/questions/update/${question_id}`,
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(response) {
                        console.log(response);
                    }
                }
            )
        }
    });

    const editQuestion  = new EditQuestion();
}


const questionRouter = new QuestionRouter();

Backbone.history.start();