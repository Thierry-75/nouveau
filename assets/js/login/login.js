import { controlEmail } from "../fields/emailtype.js";
import { controlPassword,showPassword,hidePassword } from "../fields/passwordtype.js";
import { controlRemember } from "../fields/checkboxtype.js";
import {
    clearField,
    clearRemember,
    checkFields,
    alertBorder, successBorder
} from "../fields/fieldtype.js";
window.onload = () => {
    const form_login = document.body.querySelector("#form_login");
    if (form_login) {
        const inputEmail = form_login.querySelector("#inputEmail");
        const inputPassword = form_login.querySelector("#inputPassword");
        const remember_me = form_login.querySelector("#remember_me");
        const inputSubmit = form_login.querySelector("#inputSubmit");
        const loginEye = form_login.querySelector('#loginEye');
        /**email */
        inputEmail.addEventListener("focus", function () {
            clearField(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        inputEmail.addEventListener("input", function () {
            controlEmail(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        inputEmail.addEventListener("blur", function () {
            controlEmail(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        /**password */
        inputPassword.addEventListener("focus", function () {
            clearField(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        inputPassword.addEventListener("input", function () {
            controlPassword(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        inputPassword.addEventListener("blur", function () {
            controlPassword(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });

        loginEye.addEventListener('mousedown',function(){
            showPassword(inputPassword,loginEye);
        });

        loginEye.addEventListener('mouseup',function(){
            hidePassword(inputPassword,loginEye);
        });
        /** remember */
        remember_me.addEventListener("focus", function () {
            clearRemember(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        remember_me.addEventListener("input", function () {
            controlRemember(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
        remember_me.addEventListener("focus", function () {
            controlRemember(this);
            checkFields(inputEmail, inputPassword, remember_me, inputSubmit);
        });
    }

    /**control all */
    const inputSubmit = form_login.querySelector("#inputSubmit");
    inputSubmit.addEventListener("click", function (event) {
        const inputs = form_login.getElementsByTagName("input");
        let fieldSuccess = [];
        let counter = 0;
        let nbBorder = 0;
        for (let i = 0; i < inputs.length; i++) {
            if (
                inputs[i].type === "email" ||
                inputs[i].type === "password" ||
                inputs[i].type === "checkbox"
            ) {
                fieldSuccess[i] = inputs[i];
                // console.log(fieldSuccess.length);
                if (
                    (fieldSuccess[i].type === "email" &&
                        fieldSuccess[i].value === "") ||
                    (fieldSuccess[i].type === "email" &&
                        fieldSuccess[i].classList.contains("border-red-300")) ||
                    (fieldSuccess[i].type === "password" &&
                        fieldSuccess[i].value === "") ||
                    (fieldSuccess[i].type === "password" &&
                        fieldSuccess[i].classList.contains("border-red-300"))
                ) {
                    alertBorder(fieldSuccess[i]);
                    counter++;
                }
                if (
                    (fieldSuccess[i].type === "email" &&
                        !fieldSuccess[i].value === "" &&
                        fieldSuccess[i].classList.contains(
                            "border-green-300"
                        )) ||
                    (fieldSuccess[i].type === "password" &&
                        !fieldSuccess[i].value === "" &&
                        fieldSuccess[i].classList.contains("border-green-300"))
                ) {
                    successBorder(fieldSuccess[i]);
                    nbBorder++;
                }
                if (
                    fieldSuccess[i].type === "checkbox" &&
                    !fieldSuccess[i].checked
                ) {
                    fieldSuccess[i].style.outline = "2px solid #fca5a5";
                    counter++;
                }
                if (
                    fieldSuccess[i].type === "checkbox" &&
                    fieldSuccess[i].checked
                ) {
                    fieldSuccess[i].style.outline = "2px solid #0cfa40";
                    nbBorder++;
                }
            }
        }
        if (!counter === 0 || !fieldSuccess.length === nbBorder) {
            event.preventDefault();
            event.stopImmediatePropagation();
            return false;
        }
    });
};
