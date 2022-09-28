document.getElementById('user_div').style.display = "none";
function hideForm(arg = 1) {
  if (arg) {
    document.getElementById('signup_div').style.display = "block";
    document.getElementById('login_div').style.display = "none";
  } else {
    document.getElementById('login_div').style.display = "block";
    document.getElementById('signup_div').style.display = "none";
  }
}

function login() {
  var userEmail = document.getElementById("email_field").value;

  var userPass = document.getElementById("password_field").value;

  firebase.auth().signInWithEmailAndPassword(userEmail, userPass)
    .catch(function (error) {

      // Handle Errors here.
      var errorCode = error.code;

      var errorMessage = error.message;
      console.log(error);
    });
}

function signup() {
  var userEmail = document.getElementById("email_field_1").value;

  var userPass = document.getElementById("password_field_2").value;

  firebase.auth().createUserWithEmailAndPassword(userEmail, userPass)
    .then(console.log('succes'))
    .catch(function (error) {
      // Handle Errors here.
      var errorCode = error.code;
      var errorMessage = error.message;
      // ...
    });
}
firebase.auth().onAuthStateChanged(user => {
  if (user) {
    document.getElementById('user_div').style.display = "block";
    document.getElementById('login_div').style.display = "none";
    document.getElementById('signup_div').style.display = "none";
  } else {
    document.getElementById('user_div').style.display = "none";
    document.getElementById('signup_div').style.display = "none";
    document.getElementById('login_div').style.display = "block";
  }
});
