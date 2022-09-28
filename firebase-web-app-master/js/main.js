$(document).ready(function () {
    let rootRef = firebase.database().ref().child('users')
    rootRef.on('child_added', snap => {
        let name = snap.child('name').val()
        let email = snap.child('email').val()

        $('#table-body').append('<tr><td>' + name + '</td><td>' + email + '</td><td><button class="button">remove</button></td></tr>');
    })
});