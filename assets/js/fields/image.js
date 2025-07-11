const validateImage = function (input) {
    let error = document.querySelector("#error");
    error.innerHTML = "";
    if (input.files) {
        let file = input.files[0];
        if (!file) {
            return false;
        }
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            if (reader.readyState == 2) {
                document.getElementById("image").src = reader.result;
            }
        };
        if (file.size > 1024 * 1024 * 2) {
            error.innerHTML = "Le ficheir doit être plus petit que 2 MB";
            return false;
        }
        let allowedExtension = ["jpeg", "jpg"];
        var fileExtension = document
            .getElementById("registration_form_portrait")
            .value.split(".")
            .pop()
            .toLowerCase();
        var isValid = false;
        for (var index in allowedExtension) {
            if (fileExtension === allowedExtension[index]) {
                isValid = true;
                break;
            }
        
        }
        return isValid;
    }
};

export { validateImage };
