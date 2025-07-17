const controlRemember = function (champ) {
    if (champ.checked) {
        champ.style.outline = "2px solid #0CFA40";
        return true;
    }
    if (!champ.checked) {
        champ.style.outline = "2px solid #FCA5A5";
        return false;
    }
}


export { controlRemember }
