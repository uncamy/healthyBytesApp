
function logout() {
document.cookie = 'session_id' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT';
var frame = document.createElement("iframe");
frame.src = 'http://instagram.com/accounts/logout/';
frame.onload = function() {
    location.reload();
};
document.body.appendChild(frame);
}

