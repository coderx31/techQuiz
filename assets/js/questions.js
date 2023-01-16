// const Question = Backbone.Model.extend();

// const Questions = Backbone.Collection.extend({
//     model: Question,
//     url: 'http://localhost/techQuiz/questions/get',
//     parse: function(data) {
//         return data.result;
//     }
// });

// const allQuestions = new Questions();
// allQuestions.fetch({
//     async: false,
//     success: function(collection,response, options) {
//         // TODO need to refactor this code snipet
//         console.log('success');
//         console.log(`collection - ${JSON.stringify(collection)}`);
//         console.log(`response - ${JSON.stringify(response)}`); // this is the http response
//         console.log(`options - ${JSON.stringify(options)}`);
//     },
//     error: function(colection, response, options) {
//         console.log('error');
        
//     }
// });

// console.log(allQuestions.toJSON());

// // questions view
// const QuestionsView = Backbone.View.extend({
//     el: '#content',
//     template: _.template($('#questions-template').html()),
//     collection: allQuestions,
//     initialize: function() {
//         this.render();
//     },
//     render: function() {
//         console.log('questions running');
//         console.log(this.collection.toJSON());

//         this.$el.html(this.template({
//             questions: this.collection.toJSON()
//         }));
//     }
// });

// // question view
// const QuestionView = Backbone.View.extend({
//     el: '#content',
//     template: _.template($('#question-template').html()),
//     model: set-the-model,
//     initialize: function() {
//         this.render();
//     },
//     render: function() {
//         console.log('question view running');
//         this.$el.html(this.template({
//             question: this.model.toJSON()
//         }))
//     }
// });


// // ask question view
// const AskQuestion = Backbone.View.extend({
//     el: '#content',
//     template: _.template($('ask-question').html()),
//     model: set-model,
//     initialize: function() {
//         this.render();
//     },
//     render: function() {
//         console.log('ask question view running');
//         this.$el.html(this.template({
//             question: this.model.toJSON()
//         }))
//     }
// })

// const questionsView = new QuestionsView();


const QuestionRouter = Backbone.Router.extend({
    routes: {
        "": "allQuestionsView",
        "question/:question_id": "questionView",
        "askquestion": "askQuestionView"
    },
    allQuestionsView: allQuestionsView,
    questionView: questionView,
    askQuestionView: askQuestionView
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
        collection: allQuestions,
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('questions running');
            console.log(this.collection.toJSON());
    
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
            console.log('success');
            console.log(`model - ${JSON.stringify(model)}`);
            console.log(`response - ${JSON.stringify(response)}`);
            console.log(`options - ${JSON.stringify(options)}`);
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
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('question view running');
            this.$el.html(this.template({
                question: this.model.toJSON()
            }))
        }
    });

    const questionView = new QuestionView();
} 

// askQuestionView function

function askQuestionView() {
    // const Question = Backbone.Model.extend({
    //     url: 'create-question-url'
    // });

    // const question = new Question();

    // question.create();

    // console.log(question.toJSON());

    const AskQuestion = Backbone.View.extend({
        el: '#content',
        template: _.template($('#ask-question').html()),
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('ask question view running');
            this.$el.html(this.template())
        }
    })

    const askQuestion = new AskQuestion();

}


const questionRouter = new QuestionRouter();

Backbone.history.start();