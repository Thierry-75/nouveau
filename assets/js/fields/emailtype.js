import { successBorder,alertBorder } from "./fieldtype.js";


const controlEmail = function (champ) {
    const emailRegex = new RegExp("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$");
    if (champ.value.match(emailRegex)) {
        successBorder(champ);
        return true;
    } else {
        alertBorder(champ);
        return false;
    }
}

export  {controlEmail}


