/** ^[a-zA-Z '-éàèêçïù]{10,30}$ */

import { alertBorder, successBorder } from "./fieldtype.js";

const controlPseudo = function (champ){
    const pseudoRegex = new RegExp("^.{3,27}#[0-9]{2}$");
    if(champ.value.match(pseudoRegex)){
        successBorder(champ);
        return true;
    }else if(!champ.value.match(pseudoRegex)){
        alertBorder(champ);
        return false;
    }
}

export{controlPseudo}
