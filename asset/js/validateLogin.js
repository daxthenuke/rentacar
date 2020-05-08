function validateString(str) {
    if(str.indexOf('=')){
        return false;
    }
    if (str.indexOf('(')){
        return false;
    }
    if(str.indexOf(')')){
        return false;
    }
    if(str.indexOf('/')){
        return false;
    }
    if(str.indexOf("'")){
        return false;
    }
    if (str.indexOf('"')){
        return false;
    }
}



function valdateForm() {
    let username=document.getElementsByName('username');
    let password=document.getElementsByName('password');
    let message=document.getElementsByClassName('message');

    if (username=="" || password==""){
        message.innerHTML('Molimo unesite podatke!');
    }

    if(validateString(username)==false || validateString(password)==false){
        message.innerHTML('Uneli ste nedozvoljene karaktere!');
    }
}