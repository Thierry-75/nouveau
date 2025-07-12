/** ^[a-zA-Z '-éàèêçïù]{10,30}$ */

import { alertBorder, successBorder } from "./fieldtype.js";

const controlPseudo = function (champ){
    const pseudoRegex = new RegExp("^[a-zA-Z '-éàèêçïù]{10,30}$");
    if(champ.value.match(pseudoRegex)){
        successBorder(champ);
        return true;
    }else if(!champ.value.match(pseudoRegex)){
        alertBorder(champ);
        return false;
    }
}

export{controlPseudo}
