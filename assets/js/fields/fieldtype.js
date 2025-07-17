const clearBorder = function (champ)  {
    champ.classList.remove('border-solide', 'border-2', 'border-green-300');
    champ.classList.remove('border-solide', 'border-2', 'border-red-300');
    champ.classList.add('border-none');
}

const alertBorder = function (champ) {
    champ.classList.remove('border-none', 'border-solid', 'border-2', 'border-green-300');
    champ.classList.add("border-solid", "border-2", "border-red-300");
}

const successBorder = function (champ) {
    champ.classList.remove('border-none', 'border-solid', 'border-2', 'border-red-300');
    champ.classList.add("border-solid", "border-2", "border-green-300");
}

const clearField = function (champ) {
    champ.value = "";
    clearBorder(champ);
}

const clearRemember = function (champ) {
    champ.style.outline = "none";
}

const info = function (vue, text) {
    vue.textContent = text;
};

const greenField = function (champ, text) {
    champ.style.display = 'block';
    champ.innerHTML = text;
    champ.classList.remove('text-red-300');
    champ.classList.add('text-green-300');
}

const redField = function (champ, text) {
    champ.style.display = 'block';
    champ.innerHTML = text;
    champ.classList.remove('text-green-300');
    champ.classList.add('text-red-300');
}

const yellowfield = function (champ, text) {
    champ.style.display = 'block';
    champ.innerHTML = text;
    champ.classList.remove('text-green-300, text-red-300');
    champ.classList.add('text-yellow-400');
}

const checkFields = function(champ1,champ2,champ3,bouton)
{
    if(champ1.classList.contains('border-green-300') && champ2.classList.contains('border-green-300') && champ3.checked)
    {
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent = "Validez votre saisie";
    }else{
        bouton.classList.remove('btn-validation');
        bouton.classList.add('btn-retour');
        bouton.textContent="Saisir"
    }
}
const checkFieldsUpdate = function(champ1,champ2,champ3,bouton)
{
    if(champ1.classList.contains('border-green-300') && champ2.classList.contains('border-green-300') && champ3.classList.contains('border-green-300'))
    {
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent ="Validez votre saisie";
    }else if(!champ1.classList.contains('border-green-300') && !champ1.classList.contains('border-red-300') && champ1.value==="" &&
        !champ2.classList.contains('border-green-300') && !champ2.classList.contains('border-red-300') && champ2.value==="" &&
        champ3.classList.contains('border-green-300'))
    {
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent ="Validez votre saisie";
    }else if(champ1.classList.contains('border-green-300') && !champ2.classList.contains('border-green-300') && !champ2.classList.contains('border-red-300')
        && champ2.value==="" && champ3.classList.contains('border-green-300'))
    {
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent ="Validez votre saisie";
    }else if(!champ1.classList.contains('border-green-300') && !champ1.classList.contains('border-red-300') && champ1.value ==="" &&
        champ2.classList.contains('border-green-300') && champ3.classList.contains('border-green-300'))
    {
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent ="Validez votre saisie";
    }else if(champ1.classList.contains('border-red-300')&& champ1.value !=="" || champ2.classList.contains('border-red-300') && champ2.value!==""
        || champ3.classList.contains('border-red-300') || champ3.value !==""
    )
    {
        bouton.classList.remove('btn-validation');
        bouton.classList.add('btn-retour');
        bouton.textContent ="Modifier le profil";
    }
}

const checkFieldsRegister = function(email,pseudo,password,phone,photo,rgpd,bouton){
        if(email.classList.contains('border-green-300') && pseudo.classList.contains('border-green-300') && password.classList.contains('border-green-300')
        && phone.classList.contains('border-green-300')&& photo.classList.contains('border-green-300')&& rgpd.checked){
                bouton.classList.remove('btn-retour');
                bouton.classList.add('btn-validation');
                bouton.textContent="Validez votre saisie";
        }else{
            bouton.classList.remove('btn-validation');
            bouton.classList.add('btn-retour');
            bouton.textContent="Créer votre compte";
        }
}

const checkCourriel = function(champ,bouton){
    if(champ.classList.contains('border-green-300')){
        bouton.classList.remove('btn-retour');
        bouton.classList.add('btn-validation');
        bouton.textContent="Validez ! ";
    }else{
        bouton.classList.remove('btn-validation');
        bouton.classList.add('btn-retour');
        bouton.textContent="Saisir";
    }
}

const checkPasswords = function(champ1,champ2,bouton){
        if(champ1.classList.contains('border-green-300')  && champ2.classList.contains('border-green-300') && champ1.value===champ2.value)
             {
            message.innerHTML="";
            bouton.classList.remove('btn-retour');
            bouton.classList.add('btn-validation');
            bouton.textContent = "Validez";
        }else if(champ1.classList.contains('border-red-300') || champ2.classList.contains('border-red-300') || champ1.value !==champ2.value) {
            bouton.classList.remove('btn-validation');
            bouton.classList.add('btn-retour');
            bouton.textContent = "Nouveau mot de passe";
        }
}


export {info,clearRemember,clearField,successBorder,alertBorder,clearBorder,checkFields,redField,greenField,
        yellowfield,checkFieldsRegister,checkCourriel,checkPasswords,checkFieldsUpdate}
