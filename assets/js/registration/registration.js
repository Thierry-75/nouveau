import { validateImage } from "../fields/image.js";
import { alertBorder, info, successBorder } from "../fields/fieldtype.js";

window.onload = () =>{
    const registration_form = document.body.querySelector('#registration_form');
    if(registration_form){
        const message = document.body.querySelector('#message');
        const registration_form_portrait = registration_form.querySelector('#registration_form_portrait');

        registration_form_portrait.addEventListener('focus',function(){
                let information = "Image 2Mo type jpeg/jpg";
                info(message,information);
        });
                registration_form_portrait.addEventListener('change',function(){
                        if(validateImage(this) == true) {
                            successBorder(this);
                        }else{
                            alertBorder(this);
                        }
        });
                registration_form_portrait.addEventListener('blur',function(){

        });
    }
}