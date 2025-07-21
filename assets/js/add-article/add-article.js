import { validateImage } from "../fields/imagetype.js";
import {controlTitre} from "../fields/texttype.js";
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
        const error_introduction = form_article_new.querySelector('#error_introduction');
        const error_photos = form_article_new.querySelector("#error_photos");
        const article_form_title = form_article_new.querySelector('#article_form_title');
        const article_form_introduction = form_article_new.querySelector('#article_form_contenu');
        const article_form_photos = form_article_new.querySelector("#article_form_photos");
        const article_form_new_submit = form_article_new.querySelector("#form_article_new_submit");
        const field_introduction= tinyMCE.get('article_form_contenu');


        article_form_title.addEventListener('focus',function(){
            let message ='';
            info(error_title,message);
        })

        article_form_photos.addEventListener('input',function(){
            if(this.files && this.files.length === 3){
                for (let i =0; i < this.files.length; i++){
                    validateImage(this,i);
                }
                successBorder(this);
            }
            else if(!this.files || this.files.length !==3 )
            {
                alertBorder(this);
            }
        });
        article_form_photos.addEventListener('blur',function(){
            if(this.files && this.files.length === 3){
                for (let i =0; i < this.files.length; i++){
                    validateImage(this,i);
                }
                successBorder(this);
            }else if(!this.files || this.files.length !==3)
            {
                alertBorder(this);
            }
        });

        article_form_new_submit.addEventListener('click',function(event){

            if(article_form_title.value==="" || article_form_title.value.length > 255)
            {
                let message ="Titre";
                error_title.classList.remove('text-green-600');
                error_title.classList.add('text-red-600');
                info(error_title,message);
            }
            else if(article_form_title.value !=="" && article_form_title.value.length < 255)
            {
                let message ="Titre";
                error_title.classList.remove('text-red-600');
                error_title.classList.add('text-green-600');
                info(error_title,message);
            }
            if(article_form_contenu.value ===''){
                let message ="Introduction";
                error_introduction.classList.remove('text-green-600');
                error_introduction.classList.add('text-red-600');
                info(error_introduction,message);
            }
            else if(article_form_contenu.value !=="")
            {
                let message ="Introduction";
                error_introduction.classList.remove('text-red-600');
                error_introduction.classList.add('text-green-600');
                info(error_introduction,message);
            }
            if(!article_form_photos.files || article_form_photos.files.length!==3)
            {
                alertBorder(article_form_photos);
            }
            else if(article_form_photos.files && article_form_photos.files.length===3)
            {
                successBorder(article_form_photos);
            }

            if(error_title.classList.contains('text-red-600') || error_introduction.classList.contains('text-red-600') || article_form_photos.classList.contains('border-red-300')){
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }














        });

    }
}



