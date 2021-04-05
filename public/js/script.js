const form = document.querySelector('.login-form');
const emailInput = form.querySelector('input[name="registration_form[email]"]');
const usernameInput = form.querySelector('input[name="registration_form[username]"');
const passwordInput = form.querySelector('input[name="registration_form[plainPassword][first]"');
const passwordCInput = form.querySelector('input[name="registration_form[plainPassword][second]"');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordSame(password, passwordC) {
    return password === passwordC;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') :  element.classList.remove('no-valid');
}

function validateEmail() {
    setTimeout( function() {
        markValidation(emailInput, isEmail(emailInput.value))
    }, 1000);
}

function validatePassword(){
    setTimeout( function() {
        const condition = arePasswordSame(passwordCInput.value, passwordInput.value);
        markValidation(passwordCInput, condition)
    }, 1000);
}

emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePassword);
passwordCInput.addEventListener('keyup', validatePassword);

function textCounter(field,field2,maxlimit)
{
    var countfield = document.getElementById(field2);
    if ( field.value.length > maxlimit ) {
    field.value = field.value.substring( 0, maxlimit );
    return false;
    } else {
    countfield.value = maxlimit - field.value.length;
    }
}