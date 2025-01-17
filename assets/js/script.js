var hostUrl = 'https://w1761547.users.ecs.westminster.ac.uk/techQuiz/index.php';


// access askQuestion div
// if token missing, or user not logged in, hide the askQuestion tab
if(!localStorage.getItem('token')) {
    const askQuestion = document.getElementById('askQuestion');
    if(askQuestion) {
        askQuestion.hidden = true;
    }
}

// header customization
// hide the login and register tab, if customer already login
if (localStorage.getItem('token')) {
    const logintab = document.getElementById('loginTab');
    const registertab = document.getElementById('registerTab');

    logintab.hidden = true;
    registertab.hidden = true;
} else {
    const logouttab = document.getElementById('logoutTab');
    logouttab.hidden = true;
}



// logout functionality

const logout = document.getElementById('logoutTab');

logout.addEventListener('click', (e) => {
    localStorage.clear();
    $.ajax({
        url: `${hostUrl}/users/logout`,
        type: 'POST',
        success: function(response) {
            window.location.href = `${hostUrl}/users/login`;
        },
        error: function(response) {
           flashy('failed to logout');
        }
    });
})