var hostUrl = 'https://w1761547.users.ecs.westminster.ac.uk/techQuiz';

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
            "submit": "userLogin"
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            this.$el.html(this.template())
        },
        userLogin: function(e) {
            e.preventDefault();
            this.model.set({
                username: $('#username').val(),
                password: $('#password').val()
            });

           this.model.save(
            {},
            {
                url: `${hostUrl}/users/login`,
                success: function(userdata) {
                    flashy('login success', {
                        type: 'flashy__success',
                        timeout: 1000
                    });
                    localStorage.setItem('token', userdata.attributes.token);
                    localStorage.setItem('username', userdata.attributes.username);
                    localStorage.setItem('logged_in', true);
                    localStorage.setItem('user_id', userdata.attributes.user_id);

                    setTimeout(() => {
                        window.location.href=`${hostUrl}/questions`;
                    }, 2000);
                },
                error: function(model, response, option) {
                    flashy(`${response.responseJSON.error}`, {
                        type: 'flashy__danger',
                        timeout: 2000
                    })
                }
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
            "submit": 'userRegister'
        },
        initialize: function() {
            this.render();
        },
        render: function() {
            this.$el.html(this.template())
        },
        userRegister: function(e) {
            e.preventDefault();
            this.model.set({
                firstname: $('#firstname').val(),
                lastname: $('#lastname').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password2: $('#password2').val()
            });

            this.model.save(
                {},
                {
                    url: `${hostUrl}/users/register`,
                    success: function(model, response, option) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__success',
                            timeout: 2000
                        })
                        setTimeout(() => {
                            window.location.href=`${hostUrl}/users/login`;
                        }, 2000);
                    },
                    error: function(model, response, option) {
                        flashy(`${response.responseJSON.error}`, {
                            type: 'flashy__danger',
                            timeout: 2000
                        })
                    }
                }
            )
        }

    });

    const register = new Register();
}

const userRouter = new UserRouter();

Backbone.history.start();