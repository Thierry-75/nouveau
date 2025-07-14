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
import { controlEmail } from "../fields/emailtype.js";
import { controlPseudo } from "../fields/pseudotype.js";
import { controlPassword,showPassword,hidePassword } from "../fields/passwordtype.js";
import { controlPhone } from "../fields/telephone.js";
import { controlRemember } from "../fields/checkboxtype.js";

window.onload = () => {
    const registration_form = document.body.querySelector("#registration_form");
    if (registration_form) {
        const message = document.body.querySelector("#message");
        const messageBis = document.body.querySelector("#messageBis");
        const allowEmail = document.body.querySelector("#allowEmail");
        const allowPseudo = document.body.querySelector("#allowPseudo");
        const allowPassword = document.body.querySelector("#allowPassword");
        const allowPhone = document.body.querySelector("#allowPhone");
        const allowPhoto = document.body.querySelector("#allowPhoto");
        const allowAgreeTerms = document.body.querySelector("#allowAgreeTerms");
        const registerEye = registration_form.querySelector('#registerEye');
        const password_criteria =
            document.body.querySelector("#password_criteria");
        const password_length_criteria = document.body.querySelector(
            "#password_length_criteria"
        );
        const password_special_character_criteria = document.body.querySelector(
            "#password_special_character_criteria"
        );
        const password_uppercase_criteria = document.body.querySelector(
            "#password_uppercase_criteria"
        );
        const password_number_criteria = document.body.querySelector(
            "#password_number_criteria"
        );
        const password_lowercase_criteria = document.body.querySelector(
            "#password_lowercase_criteria"
        );
        const all_password_criteria = document.body.querySelectorAll(
            "li[data-password-criteria]"
        );

        let information = "Indiquez votre adresse email";
        info(message, information);

        /** Email  */ const image = registration_form.querySelector("#image");
        const registration_form_email = registration_form.querySelector(
            "#registration_form_email"
        );

        registration_form_email.addEventListener("focus", function () {
            let information = "Indiquez votre adresse email";
            info(message, information);
            let indication = "";
            info(allowEmail, indication);
            clearField(this);
            clearBorder(this);
            password_criteria.style.display = "none";
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_email.addEventListener("input", function () {
            if (controlEmail(this) === false) {
                let text = "Adresse email incorrecte ";
                redField(allowEmail, text);
            } else if (controlEmail(this) === true) {
                let text = "Adresse email OK";
                greenField(allowEmail, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_email.addEventListener("blur", function () {
            if (controlEmail(this) === false) {
                let text = "Adresse email incorrecte ";
                redField(allowEmail, text);
            } else if (controlEmail(this) === true) {
                const image = registration_form.querySelector("#image");
                let text = "Adresse email OK";
                greenField(allowEmail, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        /** Login */
        const registration_form_login = registration_form.querySelector(
            "#registration_form_login"
        );
        registration_form_login.addEventListener("focus", function () {
            let information = "Indiquez votre pseudonyme";
            let informationBis = "10 à 30 lettres uniquement";
            info(message, information);
            info(messageBis, informationBis);
            let indication = "";
            info(allowPseudo, indication);
            clearField(this);
            password_criteria.style.display = "none";
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_login.addEventListener("input", function () {
            if (controlPseudo(this) === false) {
                let text = "Pseudonyme erroné";
                redField(allowPseudo, text);
            } else if (controlPseudo(this) === true) {
                let text = "Pseudonyme OK";
                greenField(allowPseudo, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_login.addEventListener("blur", function () {
            if (controlPseudo(this) === false) {
                let text = "Pseudonyme erroné";
                redField(allowPseudo, text);
            } else if (controlPseudo(this) === true) {
                let text = "Pseudonyme OK";
                greenField(allowPseudo, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });

        /** Password */
        const registration_form_plainPassword = registration_form.querySelector(
            "#registration_form_plainPassword"
        );

        registration_form_plainPassword.addEventListener(
            "focus",
            function ({ currentTarget }) {
                let information = "Indiquez votre mot de passe";
                info(message, information);
                let informationBis = " ";
                info(messageBis, informationBis);
                let indication = "";
                info(allowPassword, indication);
                clearField(this);
                let password = currentTarget.value;
                if (password.length === 0) {
                    all_password_criteria.forEach((li) => (li.className = ""));
                    password_length_criteria.textContent =
                        "10 caractères au total";
                }
                password_criteria.style.display = "block";
                checkFieldsRegister(
                    registration_form_email,
                    registration_form_login,
                    registration_form_plainPassword,
                    registration_form_phone,
                    registration_form_portrait,
                    registration_form_agreeTerms,
                    registration_form_submit
                );
            }
        );
        registration_form_plainPassword.addEventListener(
            "input",
            function ({ currentTarget }) {
                let password = currentTarget.value;
                password_length_criteria.className = `password-criteria-${password.length === 10
                    }`;
                password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(
                    password
                )}`;
                password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(
                    password
                )}`;
                password_number_criteria.className = `password-criteria-${/[0-9]/.test(
                    password
                )}`;
                password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(
                    password
                )}`;
                password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
                if (controlPassword(this) === false) {
                    let text = "Mot de passe erroné";
                    redField(allowPassword, text);
                } else if (controlPassword(this) === true) {
                    let text = "Mot de passe OK";
                    greenField(allowPassword, text);
                }
                checkFieldsRegister(
                    registration_form_email,
                    registration_form_login,
                    registration_form_plainPassword,
                    registration_form_phone,
                    registration_form_portrait,
                    registration_form_agreeTerms,
                    registration_form_submit
                );
            }
        );
        registration_form_plainPassword.addEventListener(
            "blur",
            function ({ currentTarget }) {
                let password = currentTarget.value;
                password_length_criteria.className = `password-criteria-${password.length === 10
                    }`;
                password_special_character_criteria.className = `password-criteria-${/[ !"#$%&'()*+,-.\/:;<=>?@\]^_`{|}~]/.test(
                    password
                )}`;
                password_uppercase_criteria.className = `password-criteria-${/[A-Z]/.test(
                    password
                )}`;
                password_number_criteria.className = `password-criteria-${/[0-9]/.test(
                    password
                )}`;
                password_lowercase_criteria.className = `password-criteria-${/[a-zà-ú]/.test(
                    password
                )}`;
                password_length_criteria.textContent = `10 caractères au total (${password.length}) `;
                if (controlPassword(this) === false) {
                    let text = "Mot de passe erroné";
                    redField(allowPassword, text);
                } else if (controlPassword(this) === true) {
                    let text = "Mot de passe OK";
                    greenField(allowPassword, text);
                }
                password_criteria.style.display = "none";
                checkFieldsRegister(
                    registration_form_email,
                    registration_form_login,
                    registration_form_plainPassword,
                    registration_form_phone,
                    registration_form_portrait,
                    registration_form_agreeTerms,
                    registration_form_submit
                );
            }
        );

        registerEye.addEventListener('mousedown',function(){
            showPassword(registration_form_plainPassword,registerEye);
        });
        registerEye.addEventListener('mouseup',function(){
            hidePassword(registration_form_plainPassword,registerEye);
        });
        /** registerEye */

        /** Telephone */
        const registration_form_phone = registration_form.querySelector(
            "#registration_form_phone"
        );
        registration_form_phone.addEventListener("focus", function () {
            let information = "Indiquez votre téléphone";
            info(message, information);
            let informationBis = "Uniquement 10 chiffres ";
            info(messageBis, informationBis);
            let indication = "";
            info(allowPhone, indication);
            clearField(this);
            password_criteria.style.display = "none";
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_phone.addEventListener("input", function () {
            if (controlPhone(this) === false) {
                let text = "N° de téléphone erroné";
                allowPhoto;
                redField(allowPhone, text);
            } else if (controlPhone(this) === true) {
                let text = "Téléphone OK";
                greenField(allowPhone, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_phone.addEventListener("blur", function () {
            if (controlPhone(this) === false) {
                let text = "N° de téléphone erroné";
                redField(allowPhone, text);
            } else if (controlPhone(this) === true) {
                let text = "Téléphone OK";
                greenField(allowPhone, text);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });

        /** image  */
        const registration_form_portrait = registration_form.querySelector(
            "#registration_form_portrait"
        );
        registration_form_portrait.addEventListener("focus", function () {
            let information = "Image 2Mo type jpeg/jpg";
            info(message, information);
            let indication = "";
            let informationBis = "";
            info(messageBis, informationBis);
            info(allowPhoto, indication);
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_portrait.addEventListener("change", function () {
            if (validateImage(this) == true) {
                successBorder(this);
                let text = "Photo OK";
                greenField(allowPhoto, text);
            } else if (validateImage(this) != true || this.value == " ") {
                let text = "Photo erronée";
                redField(allowPhoto, text);
                alertBorder(this);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_portrait.addEventListener("blur", function () {
            if (validateImage(this) == true) {
                successBorder(this);
                let text = "Photo OK";
                greenField(allowPhoto, text);
            } else if (validateImage(this) != true || this.value == " ") {
                let text = "Photo erronée";
                redField(allowPhoto, text);
                alertBorder(this);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });

        /** checkbox RGPD */
        const registration_form_agreeTerms = registration_form.querySelector(
            "#registration_form_agreeTerms"
        );
        registration_form_agreeTerms.addEventListener("focus", function () {
            information = "Accepter les R.G.P.D";
            info(message, information);
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_agreeTerms.addEventListener("input", function () {
            if (controlRemember(this) == false) {
                alertBorder(this);
                let text = "RGPD obligatoire";
                redField(allowAgreeTerms, text);
            } else if (controlRemember(this) == true) {
                successBorder(this);
                let text = "RGPD OK";
                greenField(allowAgreeTerms, text);
                information = "";
                info(message, information);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });
        registration_form_agreeTerms.addEventListener("blur", function () {
            if (controlRemember(this) == false) {
                alertBorder(this);
                let text = "RGPD obligatoire";
                redField(allowAgreeTerms, text);
            } else if (controlRemember(this) == true) {
                successBorder(this);
                let text = "RGPD OK";
                greenField(allowAgreeTerms, text);
                information = "";
                info(message, information);
            }
            checkFieldsRegister(
                registration_form_email,
                registration_form_login,
                registration_form_plainPassword,
                registration_form_phone,
                registration_form_portrait,
                registration_form_agreeTerms,
                registration_form_submit
            );
        });

        /** Submit  */
        const registration_form_submit = registration_form.querySelector(
            "#registration_form_submit"
        ); /**registration_form_submit */

        registration_form_submit.addEventListener("click", function (e) {
            let inputs = registration_form.getElementsByTagName("input");
            let compteur = 0;
            let nbBordure = 0;
            let champSuccess = [];
            for (let j = 0; j < inputs.length; j++) {
                if (
                    inputs[j].type == "email" ||
                    inputs[j].type == "text" ||
                    inputs[j].type == "password" ||
                    inputs[j].type == "file" ||
                    inputs[j].type == "checkbox"
                ) {
                    champSuccess[j] = inputs[j];
                }
            } /** end for */
            for (let i = 0; i < champSuccess.length; i++) {
                /** type email */
                if (
                    (champSuccess[i].type == "email" &&
                        champSuccess[i].value == "") ||
                    (champSuccess[i].type == "email" &&
                        champSuccess[i].classList.contains("border-red-300"))
                ) {
                    alertBorder(champSuccess[i]);
                    compteur++;
                } else if (
                    champSuccess[i].type == "email" &&
                    !champSuccess[i].value == "" &&
                    champSuccess[i].classList.contains("border-green-300")
                ) {
                    successBorder(champSuccess[i]);
                    nbBordure++;
                }
                /** type text */

                if (
                    (champSuccess[i].type == "text" &&
                        champSuccess[i].value == "") ||
                    (champSuccess[i].type == "text" &&
                        champSuccess[i].classList.contains("border-red-300"))
                ) {
                    alertBorder(champSuccess[i]);
                    compteur++;
                } else if (
                    champSuccess[i].type == "text" &&
                    !champSuccess[i].value == "" &&
                    champSuccess[i].classList.contains("border-green-300")
                ) {
                    successBorder(champSuccess[i]);
                    nbBordure++;
                }

                /**type password */
                if (
                    (champSuccess[i].type == "password" &&
                        champSuccess[i].value == "") ||
                    (champSuccess[i].type == "password" &&
                        champSuccess[i].classList.contains("border-red-300"))
                ) {
                    alertBorder(champSuccess[i]);
                    compteur++;
                } else if (
                    champSuccess[i].type == "password" &&
                    !champSuccess[i].value == "" &&
                    champSuccess[i].classList.contains("border-green-300")
                ) {
                    successBorder(champSuccess[i]);
                    nbBordure++;
                }

                /** type file */
                if (
                    champSuccess[i].type == "file" &&
                    !champSuccess[i].classList.contains("border-green-300")
                ) {
                    alertBorder(champSuccess[i]);
                    compteur++;
                } else if (
                    champSuccess[i].type == "file" &&
                    champSuccess[i].classList.contains("border-green-300")
                ) {
                    successBorder(champSuccess[i]);
                    nbBordure++;
                }

                /** type checkbox */
                if (
                    champSuccess[i].type == "checkbox" &&
                    !champSuccess[i].checked
                ) {
                    champSuccess[i].classList.remove(
                        "border",
                        "border-gray-50"
                    );
                    champSuccess[i].style.outline = "2px solid #FCA5A5";
                    compteur++;
                } else if (
                    champSuccess[i].type == "checkbox" &&
                    champSuccess[i].checked
                ) {
                    champSuccess[i].classList.remove(
                        "border",
                        "border-gray-50"
                    );
                    champSuccess[i].style.outline = "2px solid lightGreen";
                    nbBordure++;
                }
            } /** end for */

            if (
                !registration_form_agreeTerms.checked ||
                !compteur == 0 ||
                !champSuccess.length == nbBordure
            ) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });
    }
};
