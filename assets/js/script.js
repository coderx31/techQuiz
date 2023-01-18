/*
// accessing localStorage

console.log(`from script - ${localStorage.getItem('token')}`);

// access askQuestion div
// if token missing, or user not logged in, hide the askQuestion tab
if(!localStorage.getItem('token')) {
    const askQuestion = document.getElementById('askQuestion');
    askQuestion.hidden = true;
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

*/



// logout functionality

const logout = document.getElementById('logoutTab');

logout.addEventListener('click', (e) => {
    localStorage.clear();
    $.ajax({
        url: 'http://localhost/techQuiz/users/logout',
        type: 'POST',
        success: function(response) {
            //alert(JSON.stringify(response))
            console.log(JSON.stringify(response));
            window.location.href = 'http://localhost/techQuiz/users/login';
        },
        error: function(response) {
            //alert(JSON.stringify(response));
            console.log(JSON.stringify(response));
        }
    });
})