import { controlEmail } from '../fields/emailtype.js';
import { alertBorder, checkCourriel, clearField, greenField, info, redField, successBorder } from '../fields/fieldtype.js';

window.onload = () => {
    const reset_password_request = document.body.querySelector('#reset_password_request');
    if (reset_password_request) {
        const request_password_form_courriel = reset_password_request.querySelector('#request_password_form_courriel');
        const request_form_submit = reset_password_request.querySelector('#request_form_submit');
        const message = document.body.querySelector('#message');
        const allowEmail = document.body.querySelector('#allowEmail');
        let text = "Indiquez votre adresse email";
        info(message, text);
        request_password_form_courriel.addEventListener('focus', function () {
            clearField(this);
            let text = "Indiquez votre adresse email";
            info(message, text);
            let information = "";
            info(allowEmail, information);
            checkCourriel(request_password_form_courriel,request_form_submit);
        });
        request_password_form_courriel.addEventListener('input', function () {
            if (controlEmail(this) === false) {
                let text = "Adresse email erronée";
                redField(allowEmail, text);
                alertBorder(this);
            } else if (controlEmail(this) === true) {
                let text = "Email OK";
                greenField(allowEmail, text);
                successBorder(this);
            }
            let information = "";
            info(message, information);
             checkCourriel(request_password_form_courriel,request_form_submit);
        });
        request_password_form_courriel.addEventListener('blur', function () {
            if (controlEmail(this) === false) {
                let text = "Adresse email erronée";
                redField(allowEmail, text);
                alertBorder(this);
            } else if (controlEmail(this) === true) {
                let text = "Email OK";
                greenField(allowEmail, text);
                successBorder(this);
            }
            let information = "";
            info(message, information);
             checkCourriel(request_password_form_courriel,request_form_submit);
        });

        request_form_submit.addEventListener('click',function(e){
            if(!controlEmail(request_password_form_courriel)===true && !request_password_form_courriel.classList.contains('border-green-300')){
                let text = "Adresse email erronée";
                redField(allowEmail,text);
                let information="";
                info(message,information);
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });

    }
}
