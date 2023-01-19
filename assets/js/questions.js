var hostUrl = 'https://w1761547.users.ecs.westminster.ac.uk/techQuiz';

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
        url: `${hostUrl}/questions/get`,
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
        url: `${hostUrl}/questions/get?question_id=${question_id}`,
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
            'click #deleteAnswer': 'deleteAnswer',
            'click #answerUpvote': 'upVoteAnswer',
            'click #answerDownvote': 'downVoteAnswer',
            'click #editAnswer': 'editAnswer'
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
                    url: `${hostUrl}/answers/create`,
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
                    url: `${hostUrl}/questions/upvote/${question_id}`,
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
                window.location.href = `${hostUrl}/users/login`;
            }
        }),
        downVote: _.once(function() {
            if (localStorage.getItem('token')) {
                $.ajax({
                    url: `${hostUrl}/questions/downvote/${question_id}`,
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
                window.location.href = `${hostUrl}/users/login`;
            }
        }),
        deleteQuestion: function() {
            if(localStorage.getItem('token')) {
               $.ajax({
                url: `${hostUrl}/questions/delete/${question_id}`,
                headers: {
                    'Content-Type': 'application/json',
                    'x-auth': localStorage.getItem('token')
                },
                type: 'DELETE',
                success: function(response) {
                    window.location.href = `${hostUrl}/questions/`;
                },
                error: function(response) {
                    flashy(`${response.error}`, {
                        type: 'flashy__danger',
                        timeout: 2000
                    })
                }
               })
            } else {
                window.location.href = `${hostUrl}/users/login`;
            }
        },
        deleteAnswer: function() {
            const answer_id = $('#answer_id').val();
            $.ajax({
                url: `${hostUrl}/answers/delete/${answer_id}`,
                headers: {
                    'Content-Type': 'application/json',
                    'x-auth': localStorage.getItem('token')
                },
                type: 'DELETE',
                success: function(response) {
                    flashy('answer deleted', {
                        type: 'flashy__success',
                        timeout: 2000
                    });
                    window.location.reload(true);
                },
                error: function(response) {
                    console.log(response);
                    flashy(`${response.responseJSON.error}`, {
                        type: 'flashy__danger',
                        timeout: 2000
                    });
                }
            });
        },
        editAnswer: function() {
            const answer_id = $('#answer_id').val();
            const Answer = Backbone.Model.extend({
                url: `${hostUrl}/answers/get?answer_id=${answer_id}`,
                parse: function(response, options) {
                    return response.result;
                }
            });

            const answer = new Answer();
            
            answer.fetch({
                async: false,
                success: function(model, response, options) {
                },
                error: function(model, reponse, options) {
                    flashy(`${response.responseJSON.error}`, {
                        type: 'flashy__danger',
                        timeout: 2000
                    })
                }
            });

            console.log(answer)

            const body = $('#answer_body').val(answer.attributes.body);

        },
        upVoteAnswer: function() {
            if (localStorage.getItem('token')) {
                const answer_id = $('#answer_id').val();
                console.log(answer_id);
                $.ajax({
                    url: `${hostUrl}/answers/upvote/${answer_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        window.location.reload(true);
                    },
                    error: function(response) {
                        console.log(response);
                        flashy(`${JSON.stringify(response.responseJSON.error)}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                });
            } else {
                window.location.href = `${hostUrl}/users/login`;
            }
        },
        downVoteAnswer: function() {
            if (localStorage.getItem('token')) {
                const answer_id = $('#answer_id').val();
                console.log(answer_id);
                $.ajax({
                    url: `${hostUrl}/answers/downvote/${answer_id}`,
                    headers: {
                        'Content-Type': 'application/json',
                        'x-auth': localStorage.getItem('token')
                    },
                    type: 'PUT',
                    success: function(response) {
                        window.location.reload(true);
                    },
                    error: function(response) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                });
            } else {
                window.location.href = `${hostUrl}/users/login`;
            }
        }
    });

    const questionView = new QuestionView();
} 

// askQuestionView function

function askQuestionView() {
    if(localStorage.getItem('token')) {
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
                        url: `${hostUrl}/questions/create`,
                        headers: {
                            'x-auth': localStorage.getItem('token')
                        },
                        success: function(model, response, option) {
                            window.location.href=`${hostUrl}/questions`;
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
    } else {
        window.location.href = `${hostUrl}/users/login`;
    }

}

// edit question view
function editQuestionView(question_id) {

    const Question = Backbone.Model.extend({
        url: `${hostUrl}/questions/get?question_id=${question_id}`,
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
                    url: `${hostUrl}/questions/update/${question_id}`,
                    headers: {
                        'x-auth': localStorage.getItem('token')
                    },
                    success: function(response) {
                        flashy(`${response}`, {
                            type: 'flashy__success',
                            timeout: 2000
                        })
                        window.location.href=`${hostUrl}/questions`
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