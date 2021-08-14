function imageInputPreview(event) {
    const [file] = event.files;
    if(file) {
        document.querySelectorAll(".edit-profile-picture").forEach((image) => {
            image.src = URL.createObjectURL(file);
        });
}
}

function confirmBan(id, username) {
    const userlink = document.querySelector("#modal-ban-user");
    userlink.href = `index.php?page=user&action=view&user=${id}`;
    userlink.innerText = username;

    const banbtn = document.querySelector("#modal-ban-btn");
    banbtn.href = `index.php?page=admin&action=ban&user=${id}`;
}
window.addEventListener("DOMContentLoaded", (e) => {
    var toastElList = [].slice.call(document.querySelectorAll(".toast"));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    toastList.map((element) => {
            element.show();
    });
});

