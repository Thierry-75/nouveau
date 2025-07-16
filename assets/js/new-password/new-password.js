import { alertBorder, checkPasswords, clearField, greenField, info, redField, successBorder } from '../fields/fieldtype.js';
import { controlPassword ,showPassword,hidePassword} from '../fields/passwordtype.js';

window.onload = () => {
    const reset_password_form = document.body.querySelector('#reset_password_form');
    if (reset_password_form) {
        const message = document.body.querySelector('#message');
        const allowPasswordFirst = document.body.querySelector('#allowPasswordFirst');
        const allowPasswordSecond = document.body.querySelector('#allowPasswordSecond');
        const allowPasswordAll = document.body.querySelector('#allowPasswordAll')
        const resetEyeOne = document.body.querySelector('#resetEyeOne');
        const resetEyeTwo = document.body.querySelector('#resetEyeTwo');
        const password_criteria = document.body.querySelector('#password_criteria');
        const password_length_criteria = document.body.querySelector('#password_length_criteria');
        const password_special_character_criteria = document.body.querySelector("#password_special_character_criteria");
        const password_uppercase_criteria = document.body.querySelector("#password_uppercase_criteria");
        const password_number_criteria = document.body.querySelector("#password_number_criteria");
        const password_lowercase_criteria = document.body.querySelector("#password_lowercase_criteria");
        const all_password_criteria = document.body.querySelectorAll("li[data-password-criteria]");
        const firstPassword = reset_password_form.querySelector('#change_password_form_plainPassword_first');
        const secondPassword = reset_password_form.querySelector('#change_password_form_plainPassword_second');
        const change_password_form_submit = reset_password_form.querySelector('#change_password_form_submit');
        let text = 'Indiquez votre mot de passe';
        info(message, text);
        firstPassword.addEventListener('focus', function ({ currentTarget }) {
            let text = '1ère saisie du mot de passe';
            info(message, text);
            clearField(this);
            password_criteria.style.display = "block";
            let password = currentTarget.value;
            if (password.length === 0) {
                all_password_criteria.forEach((li) => (li.className = ""));
                password_length_criteria.textContent = "10 caractères au total";
            }
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });
        firstPassword.addEventListener('input', function ({ currentTarget }) {
            let password = currentTarget.value;
            password_length_criteria.className = `password-criteria-${password.length === 10}`;
            password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(password)}`;
            password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(password)}`;
            password_number_criteria.className = `password-criteria-${/[0-9]/.test(password)}`;
            password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(password)}`;
            password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
            if (controlPassword(this) === false) {
                let text = "Saisie mot de passe, erronée";
                redField(allowPasswordFirst, text);
            } else if (controlPassword(this) === true) {
                let text = "1er Mot de passe OK !";
                greenField(allowPasswordFirst, text);
            }
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });
        firstPassword.addEventListener('blur', function ({ currentTarget }) {
            let password = currentTarget.value;
            password_length_criteria.className = `password-criteria-${password.length === 10}`;
            password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(password)}`;
            password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(password)}`;
            password_number_criteria.className = `password-criteria-${/[0-9]/.test(password)}`;
            password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(password)}`;
            password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
            if (controlPassword(this) === false) {
                let text = "Mot de passe erroné";
                redField(allowPasswordFirst, text);
            } else if (controlPassword(this) === true) {
                let text = "Mot de passe 1 OK";
                greenField(allowPasswordFirst, text);
            }
            password_criteria.style.display = "none";
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });

        resetEyeOne.addEventListener('mousedown', function () {
            showPassword(firstPassword, resetEyeOne);
        });

        resetEyeOne.addEventListener('mouseup', function () {
            hidePassword(firstPassword, resetEyeOne);
        });


        secondPassword.addEventListener('focus', function ({ currentTarget }) {
            let text = '2ème saisie du mot de passe';
            info(message, text);
            clearField(this);
            password_criteria.style.display = "block";
            let password = currentTarget.value;
            if (password.length === 0) {
                all_password_criteria.forEach((li) => (li.className = ""));
                password_length_criteria.textContent = "10 caractères au total";
            }
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });
        secondPassword.addEventListener('input', function ({ currentTarget }) {
            let password = currentTarget.value;
            password_length_criteria.className = `password-criteria-${password.length === 10}`;
            password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(password)}`;
            password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(password)}`;
            password_number_criteria.className = `password-criteria-${/[0-9]/.test(password)}`;
            password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(password)}`;
            password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
            if (controlPassword(this) === false) {
                let text = "Mot de passe erroné";
                redField(allowPasswordSecond, text);
            } else if (controlPassword(this) === true) {
                let text = "Mot de passe 2 OK";
                greenField(allowPasswordSecond, text);
            }
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });
        secondPassword.addEventListener('blur', function ({ currentTarget }) {
            let password = currentTarget.value;
            password_length_criteria.className = `password-criteria-${password.length === 10}`;
            password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(password)}`;
            password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(password)}`;
            password_number_criteria.className = `password-criteria-${/[0-9]/.test(password)}`;
            password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(password)}`;
            password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
            if (controlPassword(this) === false) {
                let text = "Mot de passe erroné";
                redField(allowPasswordSecond, text);
            } else if (controlPassword(this) === true) {
                let text = "Mot de passe 2 OK";
                greenField(allowPasswordSecond, text);
            }
            password_criteria.style.display = "none";
            checkPasswords(firstPassword, secondPassword, change_password_form_submit);
        });

        resetEyeTwo.addEventListener('mousedown', function () {
            showPassword(secondPassword, resetEyeTwo);
        });

        resetEyeTwo.addEventListener('mouseup', function () {
            hidePassword(secondPassword, resetEyeTwo);
        });

        change_password_form_submit.addEventListener('click',function(e){
            let inputs = reset_password_form.getElementsByTagName('input');
            let compteur =0; let nbborder =0; let fieldSuccess =[]; let num = 0; let compareFirst; let compareSecond;
            for (let i = 0; i < inputs.length; i++)
            {
                if(inputs[i].type==='password'){
                    fieldSuccess[i]= inputs[i];
                }
            }
            for(let j = 0; j < fieldSuccess.length; j++)
            {
                if(fieldSuccess[j].value ===''  || fieldSuccess[j].classList.contains('border-red-300'))
                {
                    alertBorder(fieldSuccess[j])
                    compteur++;
                }
                else if(fieldSuccess[j].value!=="" && fieldSuccess[j].classList.contains('border-green-300'))
                {
                    successBorder(fieldSuccess[j])
                    nbborder++;
                    if(num === 0){
                        compareFirst= fieldSuccess[num];
                    }else{
                        compareSecond =fieldSuccess[num];
                    }
                    num++;
                }
            }
            if(compteur!==0 || fieldSuccess.length !== nbborder || compareFirst.value !== compareSecond.value )
            {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });

    }
}
