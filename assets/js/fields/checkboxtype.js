import { successBorder,alertBorder } from "./fieldtype.js";

const controlRemember = function (champ){
    if(champ.checked){
        champ.style.outline = "2px solid #0CFA40";
    }
    if(!champ.checked){
        champ.style.outline = "2px solid #FCA5A5";   
     }
}


export{controlRemember}
