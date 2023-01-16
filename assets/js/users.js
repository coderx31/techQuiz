const UserRouter = Backbone.Router.extend({
    routes: {
        "": "loginView",
        "register": "registerView"
    },
    loginView: loginView,
    registerView: registerView

});

//login view
function loginView() {
    const User = Backbone.Model.extend();

    const user = new User();

    const Login = Backbone.View.extend({
        el: '#content',
        template: _.template($('#login-template').html()),
        model: user,
        events: {
            "submit": "onSubmit"
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('loggin view running');
            this.$el.html(this.template())
        },
        onSubmit: function(e) {
            e.preventDefault();
            this.model.set({
                username: $('#username').val(),
                password: $('#password').val()
            });

           // alert(this.model.toJSON());
           console.log(this.model.toJSON());

           this.model.save(
            {},
            {
                url: 'http://localhost/techQuiz/users/login',
                success: function(userdata) {
                    console.log('loggin success');
                    console.log(userdata);
                    $('#login-template').trigger('reset');
                    localStorage.setItem('token', userdata.attributes.token);
                    localStorage.setItem('username', userdata.attributes.username);
                    localStorage.setItem('logged_in', true);
                    window.location.href='http://localhost/techQuiz/questions';
                },
            }
            )

        }
    });

    const login = new Login();
}

// register view
function registerView() {
    const User = Backbone.Model.extend();

    const user = new User();

    const Register = Backbone.View.extend({
        el: '#content',
        template: _.template($('#register-template').html()),
        model: user,
        events: {
            "submit": 'onSubmit'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            console.log('register view running');
            this.$el.html(this.template())
        },
        onSubmit: function(e) {
            e.preventDefault();
            this.model.set({
                firstname: $('#firstname').val(),
                lastname: $('#lastname').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password2: $('#password2').val()
            });

            console.log(this.model.toJSON());

            this.model.save(
                {},
                {
                    url: 'http://localhost/techQuiz/users/register',
                    success: function(response) {
                        console.log(response);
                        //TODO clear the register form
                        window.location.href='http://localhost/techQuiz/users/login'
                    },
                    error: function(response) {
                        console.log(response);
                    }
                }
            )
        }

    });

    const register = new Register();
}

const userRouter = new UserRouter();

Backbone.history.start();