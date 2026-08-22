

const menuBtn = document.getElementById("menuBtn");
const sideMenu = document.getElementById("sideMenu");
const overlay = document.getElementById("overlay");
const closeMenu = document.getElementById("closeMenu");

menuBtn.addEventListener("click", () => {
    // alert("clicked....");
    sideMenu.classList.add("active");
    overlay.classList.add("show");
});

closeMenu.addEventListener("click", () => {
    sideMenu.classList.remove("active");
    overlay.classList.remove("show");
});

overlay.addEventListener("click", () => {
    sideMenu.classList.remove("active");
    overlay.classList.remove("show");
});

/*install app*/
/* Install App */

let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', (e) => {

    e.preventDefault();
    deferredPrompt = e;

    if (installBtn) {
        installBtn.style.display = 'block';
    }

});

if (installBtn) {

    installBtn.addEventListener('click', async () => {

        installBtn.style.display = 'none';

        if (!deferredPrompt) return;

        deferredPrompt.prompt();

        await deferredPrompt.userChoice;

        deferredPrompt = null;

    });

}