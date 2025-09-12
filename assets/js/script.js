const popup = document.getElementById('videoPopup');
const openBtn = document.getElementById('openPopup');
const closeBtn = document.querySelector('.close');

openBtn.onclick = function() {
    popup.style.display = 'block';
}

closeBtn.onclick = function() {
    popup.style.display = 'none';
    const video = popup.querySelector('video');
    video.pause(); // stop video on close
    video.currentTime = 0;
}

window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = 'none';
        const video = popup.querySelector('video');
        video.pause();
        video.currentTime = 0;
    }
}