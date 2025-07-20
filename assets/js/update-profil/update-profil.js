import { validateImage } from "../fields/imagetype.js";
import {
    alertBorder,
    clearBorder,
    greenField,
    info,
    redField,
    successBorder,
    checkFieldsUpdate
} from "../fields/fieldtype.js";
import { controlPseudo } from "../fields/pseudotype.js";
import { controlPhone } from "../fields/telephone.js";




window.onload = () =>{
    const updateProfilForm = document.body.querySelector('#updateProfilForm');
    if(updateProfilForm){

            const allowPseudo = document.body.querySelector("#allowPseudo");
            const allowPhone  = document.body.querySelector("#allowPhone");
            const allowPhoto = document.body.querySelector('#allowPhoto');
            const message = document.body.querySelector("#message");
            const messageBis = document.body.querySelector("#messageBis");
            const update_profil_user_form_login = updateProfilForm.querySelector('#update_profil_user_form_login');
            const update_profil_user_form_phone = updateProfilForm.querySelector(('#update_profil_user_form_phone'));
            const update_profil_user_form_portrait = updateProfilForm.querySelector('#update_profil_user_form_portrait');
            const modification_form_submit = updateProfilForm.querySelector('#modification_form_submit');

        /**
         * login
         */
            update_profil_user_form_login.addEventListener('focus',function(){
                let information = "Nouveau pseudo ?";
                info(message,information);
                let informationBis = "  Facultatif * ";
                info(messageBis,informationBis);
                clearBorder(this);
                checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
            });
            update_profil_user_form_login.addEventListener('input',function(){
                if(this.value !=="") {
                    if (controlPseudo(this) === false) {
                        let text = "Pseudonyme erroné";
                        redField(allowPseudo, text);
                    } else if (controlPseudo(this) === true) {
                        let text = "Pseudonyme OK";
                        greenField(allowPseudo, text);
                    }
                }
                checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
            });
            update_profil_user_form_login.addEventListener('blur',function(){
                if(this.value !=="") {
                    if (controlPseudo(this) === false) {
                        let text = "Pseudonyme erroné";
                        redField(allowPseudo, text);
                    } else if (controlPseudo(this) === true) {
                        let text = "Pseudonyme OK";
                        greenField(allowPseudo, text);
                    }
                }
                checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
            });

        /**
         * phone
         */
        update_profil_user_form_phone.addEventListener('focus',function(){
            let information = "Numéro de téléphone ?";
            info(message,information);
            let informationBis = "  Facultatif * ";
            info(messageBis,informationBis);
            clearBorder(this);
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });
        update_profil_user_form_phone.addEventListener('input',function(){
            if(this.value !==""){
                if (controlPhone(this) === false) {
                    let text = "N° de téléphone erroné";
                    redField(allowPhone, text);
                } else if (controlPhone(this) === true) {
                    let text = "Téléphone OK";
                    greenField(allowPhone, text);
                }
            }
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });
        update_profil_user_form_phone.addEventListener('blur',function(){
            if(this.value !==""){
                if (controlPhone(this) === false) {
                    let text = "N° de téléphone erroné";
                    redField(allowPhone, text);
                } else if (controlPhone(this) === true) {
                    let text = "Téléphone OK";
                    greenField(allowPhone, text);
                }
            }
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });
        /**
         * photo
         */
        update_profil_user_form_portrait.addEventListener('focus',function(){
            let information = "Nouveau portrait ?";
            info(message,information);
            let informatioBis = "  champ obligatoire ! ";
            info(messageBis,informatioBis);
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });

        update_profil_user_form_portrait.addEventListener('change',function(){
            let num =0;
            if (validateImage(this,num)) {
                successBorder(this);
                let text = "Photo OK";
                greenField(allowPhoto, text);
            } else if (!(validateImage(this,num)) || this.files.length === 0) {
                let text = "Photo erronée";
                redField(allowPhoto, text);
                alertBorder(this);
            }
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });

        update_profil_user_form_portrait.addEventListener('blur',function(){
            let num =0;
            if (validateImage(this,num)) {
                successBorder(this);
                let text = "Photo OK";
                greenField(allowPhoto, text);
            } else if (!(validateImage(this,num)) || this.files.length === 0) {
                let text = "Photo erronée";
                redField(allowPhoto, text);
                alertBorder(this);
            }
            checkFieldsUpdate(update_profil_user_form_login,update_profil_user_form_phone,update_profil_user_form_portrait,modification_form_submit);
        });

        /**
         * submit
         */

        modification_form_submit.addEventListener('click',function(e){

            let compteur = 0; let nbBordure = 0;
            if(update_profil_user_form_portrait.classList.contains('border-red-300') || update_profil_user_form_portrait.value==="")
                {
                    alertBorder(update_profil_user_form_portrait);
                    compteur++;
                }else if(update_profil_user_form_portrait.classList.contains('border-green-300') && update_profil_user_form_portrait.value!=='')
                {
                    successBorder(update_profil_user_form_portrait);
                    nbBordure++;
                }
                if(compteur>0) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
        });

    }
}
