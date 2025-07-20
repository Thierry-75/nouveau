import { validateImage } from "../fields/imagetype.js";
import {
    alertBorder,
    clearBorder,
    clearField,
    greenField,
    info,
    redField,
    successBorder,
    checkFieldsRegister,
} from "../fields/fieldtype.js";


window.onload = () => {
    const form_article_new = document.body.querySelector("#form_article_new");
    if(form_article_new) {
        const error_title = form_article_new.querySelector("#error_title");
        const error_developpement = form_article_new.querySelector("#error_developpement");
        const error_photos = form_article_new.querySelector("#error_photos");
        const article_form_photos = form_article_new.querySelector("#article_form_photos");
        const article_form_new_submit = form_article_new.querySelector("#article_form_new_submit");


       article_form_photos.addEventListener('focus',function(){

       });
        article_form_photos.addEventListener('input',function(){
            if(this.files && this.files.length === 3){
                for (let i =0; i < this.files.length; i++){
                    validateImage(this,i);
                }
            }



        });
        article_form_photos.addEventListener('blur',function(){

        });
    }
}



