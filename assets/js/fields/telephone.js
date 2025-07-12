import { successBorder,alertBorder } from "./fieldtype.js";


const controlPhone = function (champ)
{
     const phoneRegex  = new RegExp('^[0-9]{10,10}$');
     if(champ.value.match(phoneRegex) )
     {
          successBorder(champ);
          return true;
     }else if(!champ.value.match(phoneRegex))
     {
          alertBorder(champ);
          return false;
     }
}



export{controlPhone}