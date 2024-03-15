






window.addEventListener('beforeunload', function (e) {
    e.preventDefault();
    e.returnValue = '';
});





document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        document.querySelector('#new-chat-overlay').style.display = 'flex';
    }, 2000);
}); 