

const validateImage = function (input,num) {
    let error = document.querySelector("#error");
    let retour = false;
    error.innerHTML = "";
    if (input.files) {
        let file = input.files[num];
        if (!file) {
            return retour;
        }
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            if (reader.readyState === 2) {
                document.getElementById("image"+num).src = reader.result;
            }
            num++;
        };
        if (file.size > 1024 * 1024 * 2) {
            error.innerHTML = "Le ficheir doit être plus petit que 2 MB";
            return retour;
        }
        let allowedExtension = ["jpeg", "jpg"];
        let fileExtension = input.value.split(".").pop().toLowerCase();

        for (let index in allowedExtension) {
            if (fileExtension === allowedExtension[index]) {
            retour = true;
                break;
            }

        }
        return retour;
    }
};

export { validateImage };
