const previewPicture = function (e) {
    const [picture] = e.files
    const types = ["image/jpg", "image/jpeg", "image/png","image/svg+xml"];
    if (picture) {
        const image = document.getElementById("image");
        if (types.includes(picture.type)) {
            const reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result
            }
            reader.readAsDataURL(picture)
        }
    }
}