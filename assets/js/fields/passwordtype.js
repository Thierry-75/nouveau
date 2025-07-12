import { alertBorder, successBorder } from "./fieldtype.js";

const controlPassword = function (champ){
    const passwordRegex = new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{10}$");
    if(champ.value.match(passwordRegex)){
        successBorder(champ);
        return true;
    }else if(!champ.value.match(passwordRegex))
    {
        alertBorder(champ);
        return false;
    }
}

const showPassword = function(input,btn){
    if(input.type ==='password'){
        input.type ='text';
        btn.classList.add('active');
    }
}
const hidePassword = function(input,btn){
    if(input.type ==='text'){
        input.type ='password';
        btn.classList.remove('active');
    }
}

export{controlPassword,showPassword,hidePassword}