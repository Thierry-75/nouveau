import { alertBorder, successBorder } from "./fieldtype.js";

const controlTitre = function(champ){
    if(champ.value ==='' || champ.value.length > 225 )
    {
        alertBorder(champ);
        return false
    }
    else if (champ.value !=='' && champ.value.length < 255)
    {
        successBorder(champ);
        return true;
    }
}

export {controlTitre}
