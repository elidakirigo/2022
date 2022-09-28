var fireHeading = document.getElementById('fireHeading')
var main_text = document.getElementById('main_text')
var button = document.getElementById('button')
let firebaseheading = firebase.database().ref().child('heading');

firebaseheading.on('value', datasnapshot => {
fireHeading.innerText = datasnapshot.val();
})

function submitClick() {
  let firebaseRef = firebase.database().ref();
  let message = main_text.value;
  console.log(message);
  // firebaseRef.child('text').set(message);
  firebaseRef.push().set(message);
}