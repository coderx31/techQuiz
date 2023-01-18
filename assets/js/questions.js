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
            
        },
        error: function(colection, response, options) {
            flashy(`${response.responseJSON.error}`, {
                type: 'flashy__danger',
                timeout: 2000
            })
            
        }
    });


    const QuestionsView = Backbone.View.extend({
        el: '#content',
        template: _.template($('#questions-template').html()),
        collection: allQuestions,
        initialize: function() {
            this.render();
        },
        render: function() {
            this.$el.html(this.template({
                questions: this.collection.toJSON()
            }));
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
        },
        error: function(model, reponse, options) {
            flashy(`${response.responseJSON.error}`, {
                type: 'flashy__danger',
                timeout: 2000
            })
        }
    })

    const QuestionView = Backbone.View.extend({
        el: '#content',
        template: _.template($('#question-template').html()),
        model: question,
        events: {
            'submit': 'addAnswer',
            'click #upvote': 'upVote',
            'click #downvote': 'downVote',
            'click #deleteQuestion': 'deleteQuestion',
            'click #deleteAnswer': 'deleteAnswer'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            this.$el.html(this.template({
                question: this.model.toJSON()
            }))
        },
        addAnswer: function(e) {
            e.preventDefault();

            const Answer = Backbone.Model.extend();

            const answer = new Answer();

            answer.set({
                question_id: $('#question_id').val(),
                body: $('#answer_body').val()
            });

            answer.save(
                {},
                {
                    url: 'http://localhost/techQuiz/answers/create',
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        window.location.reload(true);
                    },
                    error: function(response) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                }
            )

        },
        upVote: _.once(function() {
            if(localStorage.getItem('token')) {
                $.ajax({
                    url: `http://localhost/techQuiz/questions/upvote/${question_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        window.location.reload(true);
                    },
                    error: function(response) {
                        flashy(`${response.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                });
            } else {
                window.location.href = 'http://localhost/techQuiz/users/login';
            }
        }),
        downVote: _.once(function() {
            if (localStorage.getItem('token')) {
                $.ajax({
                    url: `http://localhost/techQuiz/questions/downvote/${question_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        window.location.reload(true);
                    },
                    error: function(response) {
                        flashy(`${response.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
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
                    window.location.href = 'http://localhost/techQuiz/questions/';
                },
                error: function(response) {
                    flashy(`${response.error}`, {
                        type: 'flashy__danger',
                        timeout: 2000
                    })
                }
               })
            } else {
                window.location.href = 'http://localhost/techQuiz/users/login';
            }
        },
        deleteAnswer: function() {
            // TODO need to implement this feature
            flashy('messages', {
                type: 'flashy__success'
            })
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
            this.$el.html(this.template())
        },
        askQuestion: function(e) {
            e.preventDefault();
            this.model.set({
                title: $('#title').val(),
                body: $('#body').val()
            });

            this.model.save(
                {},
                {
                    url: 'http://localhost/techQuiz/questions/create',
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(model, response, option) {
                        window.location.href='http://localhost/techQuiz/questions';
                    },
                    error: function(model, response, error) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                }
            )
        }
    });

    const askQuestion = new AskQuestion();

}

// edit question view
function editQuestionView(question_id) {

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
            
        },
        error: function(model, reponse, options) {
            flashy(`${response.responseJSON.error}`, {
                type: 'flashy__danger',
                timeout: 2000
            })
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

            this.model.save(
                {},
                {
                    url: `http://localhost/techQuiz/questions/update/${question_id}`,
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__success',
                            timeout: 2000
                        })
                    },
                    error: function(response) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                }
            )
        }
    });

    const editQuestion  = new EditQuestion();
}


const questionRouter = new QuestionRouter();

Backbone.history.start();