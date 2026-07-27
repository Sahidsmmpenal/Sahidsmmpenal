document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menuBtn");
    const sidebarMenu = document.getElementById("sidebarMenu");

    if (menuBtn && sidebarMenu) {
        menuBtn.addEventListener("click", () => {
            sidebarMenu.classList.toggle("active");
        });
    }
});
