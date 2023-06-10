document.addEventListener("DOMContentLoaded",e=>{
    const imgTop = document.querySelector("img.top");
    document.querySelectorAll("img[data-uid]").forEach(e => {
        e.addEventListener("click", ev => {
            let uid = e.getAttribute("data-uid");
            window.location.href = `user.php?id=${uid}`;
        });
    });
})